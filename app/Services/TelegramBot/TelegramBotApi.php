<?php

namespace App\Services\TelegramBot;

use App\Services\TelegramBot\Exceptions\ApiError;
use App\Services\TelegramBot\Exceptions\BadConfigException;
use App\Services\TelegramBot\Models\Updates;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class TelegramBotApi
{
    const MESSAGE_TYPE_TEXT       = 'text';
    const MESSAGE_TYPE_VOICE      = 'voice';
    const MESSAGE_TYPE_VIDEO      = 'video';
    const MESSAGE_TYPE_AUDIO      = 'audio';
    const MESSAGE_TYPE_DOCUMENT   = 'document';
    const MESSAGE_TYPE_VIDEO_NOTE = 'video_note';
    const MESSAGE_TYPE_PHOTO      = 'photo';

    const UNSUPPORTED_MESSAGE_TYPE = null;

    protected string  $name;
    protected string  $token;
    protected string  $secret;
    protected ?object $http;

    public function __construct(array $config)
    {
        throw_if(
            !$config || !$config['token'] || !$config['secret'] || !$config['name'],
            new BadConfigException('')
        );
        $this->name   = $config['name'];
        $this->token  = $config['token'];
        $this->secret = $config['secret'];
        $this->http   = new Client([
            'base_uri' => "https://api.telegram.org/bot{$this->token}/",
        ]);
    }

    public static function getType ($message)
    {
        switch (true) {
            case isset($message['text']):       return self::MESSAGE_TYPE_TEXT;
            case isset($message['voice']):      return self::MESSAGE_TYPE_VOICE;
            case isset($message['video']):      return self::MESSAGE_TYPE_VIDEO;
            case isset($message['audio']):      return self::MESSAGE_TYPE_AUDIO;
            case isset($message['document']):   return self::MESSAGE_TYPE_DOCUMENT;
            case isset($message['video_note']): return self::MESSAGE_TYPE_VIDEO_NOTE;
            case isset($message['photo']):      return self::MESSAGE_TYPE_PHOTO;
            default:                            return self::UNSUPPORTED_MESSAGE_TYPE;
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function checkSecret($value): bool
    {
        return hash_equals($this->secret, $value);
    }

    public function getFileInfo(string $fileId)
    {
        $info = $this->execRequest('POST', 'getFile', ['json' => ['file_id' => $fileId]]);
        // download link https://api.telegram.org/file/bot<token>/<file_path>
        $info['link'] = "https://api.telegram.org/file/bot{$this->token}/{$info['file_path']}";
        return $info;
    }

    public function getMe()
    {
        return $this->execRequest('GET', 'getMe');
    }

    public function getUpdates(bool $rawResults = true)
    {
        $data = $this->execRequest('GET', 'getUpdates');
        $res  = [];

        if (!$rawResults) {
            foreach ($data as $item) {
                $res[] = Updates::create(['data' => $item,]);
            }
        }

        return $rawResults ? $data : $res;
    }

    public function setWebhook($url)
    {
        return $this->execRequest('POST', 'setWebhook', ['json' => ['url' => $url,]]);
    }

    public function deleteWebhook()
    {
        return $this->setWebhook(null);
    }

    public function getWebhookInfo()
    {
        return $this->execRequest('GET', 'getWebhookInfo');
    }

    public function sendTextMessage($tgChatId, $text, int $replyTo = 0, $parseMode = 'Markdown')
    {
        $data = [
            'chat_id'    => $tgChatId,
            'text'       => $text,
            'parse_mode' => $parseMode,
        ];

        if ($replyTo) $data['reply_to_message_id'] = $replyTo;

        return $this->execRequest('POST', 'sendMessage', ['json' => $data]);
    }

    public function sendDocument($tgChatId, $filePath, $fileName = null, $caption = null, int $replyTo = 0, $parseMode = 'Markdown')
    {
        $realPath     = storage_path('app') . '/' . $filePath;
        $realFileName = $fileName ?? pathinfo($realPath)['basename'];

        $data = [
            [
                'name'     => 'chat_id',
                'contents' => $tgChatId
            ],
            [
                'name'     => 'parse_mode',
                'contents' => $parseMode
            ],
            [
                'name'     => 'document',
                'contents' => fopen($realPath, 'r'),
                'filename' => $realFileName,
            ],
        ];

        if ($caption) $data[] = ['name' => 'caption', 'contents' => $caption];
        if ($replyTo) $data[] = ['name' => 'reply_to_message_id', 'contents' => $replyTo];

        return $this->execRequest('POST', 'sendDocument', ['multipart' => $data]);
    }

    public function extractData ($message)
    {
        $type = self::getType($message);

        $fileTypes = [
            self::MESSAGE_TYPE_VOICE,
            self::MESSAGE_TYPE_VIDEO,
            self::MESSAGE_TYPE_AUDIO,
            self::MESSAGE_TYPE_DOCUMENT,
            self::MESSAGE_TYPE_VIDEO_NOTE,
        ];

        $result = [
            'type'    => $type,
            'payload' => null,
        ];

        if (in_array($type, $fileTypes) && ($file = $message[$type])) {
            // process as file
            $file_info  = $this->getFileInfo($file['file_id']);
            $result['payload'] = $file_info['link'];
        } elseif ($type === self::MESSAGE_TYPE_PHOTO and $photos = $message['photo'] ?? null) {
            // process as image
            $file = $photos[0];
            foreach ($photos as $photo) {
                if ($photo['file_size'] > $file['file_size']) $file = $photo;
            }
            $file_info  = $this->getFileInfo($file['file_id']);
            $result['payload'] = $file_info['link'];
        } elseif ($type === self::MESSAGE_TYPE_TEXT) {
            // process as text
            $result['payload'] = $message['text'] ?? null;
        } else {
            $result['payload'] = null;
        }

        return $result;
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
