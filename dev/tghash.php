<?php

$str1 = 'cdcd72f42bc003bc3d81e45652aaeb13e94f04c9d91fa548c4d54217ef0fb001';
$botToken = '5344600531:AAFyxRbXaYYachsT4c1k5k_lY8RGRvzkGas';

define('BOT_TOKEN', '5344600531:AAFyxRbXaYYachsT4c1k5k_lY8RGRvzkGas');

$auth_data = [
    'auth_date' => 1652815272,
    'first_name' => "M",
    'hash' => "cdcd72f42bc003bc3d81e45652aaeb13e94f04c9d91fa548c4d54217ef0fb001",
    'id' => 1016786406,
    'last_name' => "F",
    'photo_url' => "https://t.me/i/userpic/320/orjJ1PNjLGqHIH92N1ElVC2Z_dcYUxtdEYe3i6txYZc.jpg",
    'username' => "uretral",
];

function checkTelegramAuthorization($auth_data)
{
    $check_hash = $auth_data['hash'];
    unset($auth_data['hash']);
    $data_check_arr = [];
    foreach ($auth_data as $key => $value) {
        $data_check_arr[] = $key . '=' . $value;
    }
    sort($data_check_arr);
    $data_check_string = implode("\n", $data_check_arr);
    $secret_key = hash('sha256', BOT_TOKEN, true);
    $hash = hash_hmac('sha256', $data_check_string, $secret_key);
    if (strcmp($hash, $check_hash) !== 0) {
        throw new Exception('Data is NOT from Telegram');
    }
    if ((time() - $auth_data['auth_date']) > 86400) {
        throw new Exception('Data is outdated');
    }
    return $auth_data;
}

function saveTelegramUserData($auth_data)
{
    $auth_data_json = json_encode($auth_data);
    echo $auth_data_json;
//    setcookie('tg_user', $auth_data_json);
}


try {
    $auth_data = checkTelegramAuthorization($auth_data);
    saveTelegramUserData($auth_data);

} catch (Exception $e) {
    die ($e->getMessage());
}

