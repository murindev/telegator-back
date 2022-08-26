<?php

namespace App\Processors;

use App\Utils\ChromerClient;
use Exception;

class HidemyNameList
{
    const PROXY_LIST_URL = 'https://hidemy.name/ru/proxy-list';

    public function handle()
    {
        $chromer = new ChromerClient(env('CHROMER_ADDR'), env('CHROMER_AUTH_KEY'));

        $url = static::PROXY_LIST_URL . '/?' . http_build_query(array(
                'type' => 'hs', // http/https
                'anon' => '34',
            ));

        $res = $chromer->acquire(array(
            'userAgent'               => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36',
            'blockNewWebContents'     => false,
            'disableWebSecurity'      => true,
            'ignoreCertificateErrors' => true,
            'leaveWebdriverTraces'    => false,
            'url'                     => 'about:blank',
        ));

        $chromer->page_addScriptToEvaluateOnNewDocument(array(
            'source' => <<<JAVASCRIPT
		const UTILS = {
			nonemptyResult: async function (fn, timeout, interval, attempts) {
				let time = Date.now();
				let cnt = 0;
				let res;
				while (true) {
					cnt++;
					res = await Promise.resolve(fn());
					if (res) {
						return res;
					}
					else if (timeout > 0 && Date.now() - time > timeout) {
						return null;
						// throw new Error("Retry error: timeout");
					}
					else if (attempts > 0 && cnt >= attempts) {
						return null;
						// throw new Error("Retry error: max attempts");
					}
					else {
						await this.sleep(interval || 1000);
					}
				}
			},
			sleep: async function (ms) {
				ms = ms || 500;
				return new Promise(resolve => setTimeout(resolve, ms));
			},
			randSleep: async function (ms) {
				ms = ms || 500;
				ms += (ms * 0.5) * (Math.random() - 0.5);
				return this.sleep(ms);
			},
		};
JAVASCRIPT
        ));

        $res = $chromer->navigate(array(
            'url' => $url,
            'referrer' => '',
            'transitionType' => 'address_bar',
        ));

        $res = null;
        $err = null;
        while (true) {
            // wait for successful script execution
            try {
                // parse table:
                $args = [];
                $res = $chromer->evaluate(array(
                    'js' => <<<JAVASCRIPT
				(async function (args) {
					let trs = await UTILS.nonemptyResult(() => {
						let trs = document.querySelectorAll('.table_block table tbody > tr');
						return !trs.length ? null : Array.from(trs);
					});
					if (!trs) {
						throw new Error("Unable to find proxy table rows");
					}
					return trs.map((tr) => {
						let country = tr.children[2].querySelector('.flag-icon');
						country = /flag-icon-([a-z]{2})/.exec(country.className);
						country = country && country[1].toUpperCase() || null;

						return {
							host: tr.children[0].textContent.trim(),
							port: tr.children[1].textContent.trim(),
							country: country,
							types: tr.children[4].textContent.trim().split(/\s*,\s*/),
							// _trHtml: tr.outerHTML,
						};
					});
				})
JAVASCRIPT
                        . '(' . json_encode($args) . ')'
                ));
                break;
            }
            catch (Exception $err) {
                if (preg_match('/execution.*context.*destroy/i', $err->getMessage())) {
                    continue;
                }
                throw $err;
            }
        }

        return $res;
    }
}
