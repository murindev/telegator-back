<?php

namespace App\Http\Controllers\Parse;

use App\Http\Controllers\ConvertController;
use App\Models\Channel;
use App\Models\Statistics\AvgAdvertView;
use App\Models\Statistics\AvgCiting;
use App\Models\Statistics\AvgDailySubscription;
use App\Models\Statistics\AvgPostView;
use App\Models\Statistics\AvgSex;
use App\Models\Statistics\AvgSubscriber;
use App\Models\Statistics\AvgPostCount;
use Symfony\Component\DomCrawler\Crawler;

class StatController extends ConvertController
{
    public array $result = [];

    public $arrValues = null;

    public $channel_id = null;


    public function init()
    {
        $this->channel_id = null;
        $name = request('name');
        $link = 'https://uk.tgstat.com/channel/' . $name . '/stat';
        $this->getId();
        if($this->channel_id){
            try {
                $this->parseSummaryStat($link);
                $this->setValues();
                return $this->arrValues;
            } catch (\Exception $e) {
                return $e;
            }
        } else {
            return null;
        }

    }

    public function getId()
    {
        if($channel = Channel::where('tg_link','https://t.me/'.request('name'))->first()) {
            $this->channel_id = $channel->getAttribute('id');
        }
    }

    public function parseSummaryStat($link)
    {
        $html = file_get_contents($link);
        $crawler = new Crawler(null, $link);
        $crawler->addHtmlContent($html, 'UTF-8');

        $stats = $crawler->filterXPath('//*[@id="sticky-center-column"]/div/div/div')
            ->each(function (Crawler $crawler) {

                try {
                    $title = $crawler->filter('.text-uppercase')->first()->text();
                } catch (\Exception $e) {
                }

                try {
                    $common = $crawler->filter('h2')->first()->text();
                } catch (\Exception $e) {
                }


                if ($title === 'пол подписчиков') {
                    return $this->bCrawler($crawler, $title, $common ?? '');
                } else {
                    return $this->trCrawler($crawler, $title, $common ?? '');
                }


            });

        $this->result = $stats;
        return $this->result;
    }

    public function trCrawler($crawler, $title, $common)
    {
        return [
            'title' => $title ?? '',
            'common' => $common ?? '',
            'nodes' => $crawler->filter('tr')->each(function (Crawler $crawler) {
                try {
                    $title = $crawler->filter('td')->eq(1)->text();
                } catch (\Exception $e) {
                }

                try {
                    $value = $crawler->filter('td')->eq(0)->text();
                } catch (\Exception $e) {
                }

                return [
                    'title' => $title ?? '',
                    'value' => $value ?? ''
                ];
            })
        ];
    }

    public function bCrawler($crawler, $title, $common)
    {
        return [
            'title' => $title ?? '',
            'common' => $common ?? '',
            'nodes' => $crawler->filter('.text-dark')->each(function (Crawler $crawler) {
                try {
                    $title = $crawler->filter('b')->eq(1)->text();
                } catch (\Exception $e) {
                }

                try {
                    $value = $crawler->filter('b')->eq(0)->text();
                } catch (\Exception $e) {
                }

                return [
                    'title' => $title ?? '',
                    'value' => $value ?? ''
                ];
            })
        ];
    }


    public function setValues()
    {
        $this->arrValues = null;

        foreach ($this->result as $k => $val) if($val) {

            if ($val['title'] != 'вовлеченность подписчиков (ERR)') {

                if ($val['title'] == 'подписчики') {
                    $model = new AvgSubscriber();
                    $this->avg_subscribers('avg_subscribers', $val, $model);
                }

                if ($val['title'] == 'Подписки/отписки за 24 часа') {
                    $model = new AvgDailySubscription();
                    $this->avg_daily_subscriptions('avg_daily_subscriptions', $val, $model);
                }

                if ($val['title'] == 'индекс цитирования') {
                    $model = new AvgCiting();
                    $this->avg_citings('avg_citings', $val, $model);
                }

                if ($val['title'] == 'средний охват 1 публикации') {
                    $model = new AvgPostView();
                    $this->avg_post_views('avg_post_views', $val, $model);
                }

                if ($val['title'] == 'средний рекламный охват 1 публикации') {
                    $model = new AvgAdvertView();
                    $this->avg_advert_views('avg_advert_views', $val, $model);
                }

                if ($val['title'] == 'публикации') {
                    $model = new AvgPostCount();
                    $this->post_counts('post_counts', $val, $model);
                }

                if ($val['title'] == 'пол подписчиков') {
                    $model = new AvgSex();
                    $this->avg_sexes('avg_sexes', $val, $model);
                }

            }

        }

    }

    public function avg_subscribers($table, $val, $model)
    {
        $this->arrValues[$table] = [
            'channel_id' => $this->channel_id,
            'total' => $this->onlyInt($val['common']),
            'day' => $val['nodes'][0]['value'],
            'week' => $val['nodes'][1]['value'],
            'month' => $val['nodes'][2]['value'],
        ];

        $this->saveData($model, $this->arrValues[$table]);

    }

    public function avg_daily_subscriptions($table, $val, $model)
    {
        $this->arrValues[$table] = [
            'channel_id' => $this->channel_id,
            'total' => $val['common'],
            'plus' => $val['nodes'][0]['value'],
            'minus' => $val['nodes'][1]['value'],
        ];
        $this->saveData($model, $this->arrValues[$table]);
    }

    public function avg_citings($table, $val, $model)
    {
        $this->arrValues[$table] = [
            'channel_id' => $this->channel_id,
            'total' => $val['common'],
            'channel_mentions' => $val['nodes'][0]['value'],
            'mentions' => $val['nodes'][1]['value'],
            'reposts' => $val['nodes'][2]['value'],
        ];
        $this->saveData($model, $this->arrValues[$table]);
    }

    public function avg_advert_views($table, $val, $model)
    {
        $this->arrValues[$table] = [
            'channel_id' => $this->channel_id,
            'total' => $this->onlyInt($val['common']),
            'half_day' => $val['nodes'][0]['value'],
            'day' => $val['nodes'][1]['value'],
            'two_day' => $val['nodes'][2]['value'],
        ];
        $this->saveData($model, $this->arrValues[$table]);
    }

    public function avg_post_views($table, $val, $model)
    {
        $this->arrValues[$table] = [
            'channel_id' => $this->channel_id,
            'total' => $this->onlyInt($val['common']),
            'err' => $val['nodes'][0]['value'],
            'err_daily' => $val['nodes'][1]['value'],
        ];
        $this->saveData($model, $this->arrValues[$table]);
    }

    public function post_counts($table, $val, $model)
    {
        $this->arrValues[$table] = [
            'channel_id' => $this->channel_id,
            'total' => $this->onlyInt($val['common']),
            'day' => $val['nodes'][0]['value'],
            'week' => $val['nodes'][1]['value'],
            'month' => $val['nodes'][2]['value'],
        ];
        $this->saveData($model, $this->arrValues[$table]);
    }

    public function avg_sexes($table, $val, $model)
    {
        $this->arrValues[$table] = [
            'channel_id' => $this->channel_id,
            'male' => $val['nodes'][0]['value'],
            'female' => $val['nodes'][1]['value'],
        ];
        $this->saveData($model, $this->arrValues[$table]);
    }



    public function onlyInt($val)
    {
        return (int)preg_replace("/[^,.0-9]/", '', $val);
    }


    public function saveData($model, $data){
        $model->updateOrCreate(['id' => $this->channel_id],$data);
    }


}
