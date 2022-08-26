<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Exceptions\BadConfigException;

class SolarStaffApi
{
    protected int     $client_id;
    protected string  $api_url;
    protected string  $salt;
    protected ?object $http;

    public function __construct(array $config)
    {
        throw_if(
            !$config || !$config['client_id'] || !$config['api_url'] || !$config['salt'],
            new BadConfigException('')
        );
        $this->client_id = $config['client_id'];
        $this->api_url   = $config['api_url'];
        $this->salt      = $config['salt'];
        $this->http      = new Client([
            'base_uri' => "{$this->api_url}/v1/",
        ]);
    }

    public function simpleCall (string $name , array $payload = null)
    {
        return is_null($payload)
            ? $this->execRequest('GET', $name)
            : $this->execRequest('POST', $name, ['json' => $payload]);
    }

    private function execRequest($method, $uri, array $params = [])
    {
        try {
            $res = $this->http->request($method, $uri, $params);
        } catch (ClientException $exception) {
            if ($exception->getCode() === 403) {
                $tg_chat_id = 0;
                if (isset($params['json']) && isset($params['json']['chat_id'])) $tg_chat_id = $params['json']['chat_id'];
                if (isset($params['multipart']) && isset($params['multipart'][0]['name']) && $params['multipart'][0]['name'] = 'chat_id') $tg_chat_id = $params['multipart'][0]['contents'];
                echo "user [telegram_chat_id=${tg_chat_id}] has blocked this bot";
                return false;
            } else throw $exception;
        }
        throw_if($res->getStatusCode() !== 200, new ApiError('TelegramApi response status code != 200'));
        $data = json_decode($res->getBody()->getContents(), true);
        throw_if($data === null, new ApiError('TelegramApi response is null'));
        throw_if($data['ok'] !== true, new ApiError($data['description'] ?? 'error'));
        return $data['result'];
    }
}
