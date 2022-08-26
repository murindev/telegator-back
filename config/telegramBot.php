<?php

$id  = env('TG_BOT_ID', 0);
$key = env('TG_BOT_KEY', 'undefined');

return [
    'name'   => env('TG_BOT_NAME', 'undefined'),
    'id'     => $id,
    'key'    => $key,
    'token'  => env('TG_BOT_TOKEN', "$id:$key"),
    'secret' => env('TG_BOT_SECRET', 'bot catcher secret key dummy')
];
