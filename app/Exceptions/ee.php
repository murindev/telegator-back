<?php

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

$MadelineProto = new \danog\MadelineProto\API('session.madeline');
$MadelineProto->start();

$me = $MadelineProto->getSelf();

$MadelineProto->logger($me);

if (!$me['bot']) {
    // This example uses PHP 7.1+ syntax with arrays
    $MadelineProto->messages->sendMessage(['peer' => '@danogentili', 'message' => "Hi!\nThanks for creating MadelineProto (PHP 7)! <3"]);

    // This example uses PHP 8.0+ syntax with named arguments
    $MadelineProto->messages->sendMessage( '@danogentili',  "Hi!\nThanks for creating MadelineProto (PHP 8)! <3");

    $MadelineProto->channels->joinChannel( '@MadelineProto');

    try {
        $MadelineProto->messages->importChatInvite('https://t.me/joinchat/Bgrajz6K-aJKu0IpGsLpBg');
    } catch (\danog\MadelineProto\RPCErrorException $e) {
        $MadelineProto->logger($e);
    }

    $MadelineProto->messages->sendMessage( 'https://t.me/joinchat/Bgrajz6K-aJKu0IpGsLpBg',  'Testing MadelineProto!');
}
$MadelineProto->echo('OK, done!');
