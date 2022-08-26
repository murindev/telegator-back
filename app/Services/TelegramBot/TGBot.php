<?php

namespace App\Services\TelegramBot;

use App\Models\Channel;
use App\Models\TelegramUser;

class TGBot
{


    public static function message($chat_id,$text) {
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . \config('app.tg_token') . '/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    'chat_id' => $chat_id,
                    'text' => $text,
                ),
            )
        );

        return curl_exec($ch);
    }

    public static function sendMessageByChannelId($channel_id, $text) {
        $channel = Channel::where('id',$channel_id)->first();
        $tgUser = TelegramUser::where('user_id', $channel->owner_id)->first();
        if($tgUser) {
            return self::message($tgUser->id, $text);
        }

    }


    public static function sendMessageByUserId($user_id, $text) {

        $tgUser = TelegramUser::where('user_id', $user_id)->first();
        if($tgUser) {
           return self::message($tgUser->id, $text);
        }

    }



}
