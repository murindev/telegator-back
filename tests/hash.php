<?php


use Illuminate\Validation\ValidationException;

$str = '{
  "id": 1016786406,
  "first_name": "M",
  "last_name": "F",
  "username": "uretral",
  "photo_url": "https://t.me/i/userpic/320/orjJ1PNjLGqHIH92N1ElVC2Z_dcYUxtdEYe3i6txYZc.jpg",
  "auth_date": 1653630601,
  "hash": "e6dbdf67a1d8d9c8f2f1d5c48fae6c14f009375937ce11430a295b1f785a9fb5"
}';

$auth_data = (array)json_decode($str);



function checkTelegramAuth(array $auth_data)
{
    $check_hash = $auth_data['hash'];
    unset($auth_data['hash']);
    $data_check_arr = [];
    foreach ($auth_data as $key => $value) {
        $data_check_arr[] = $key . '=' . $value;
    }
    sort($data_check_arr);
    $data_check_string = implode("\n", $data_check_arr);
    $secret_key = hash('sha256', '5344600531:AAFyxRbXaYYachsT4c1k5k_lY8RGRvzkGas', true);
    $hash = hash_hmac('sha256', $data_check_string, $secret_key);
    if (strcmp($hash, $check_hash) !== 0) {
        return 'Data is NOT from Telegram';
    }
    if ((time() - $auth_data['auth_date']) > 86400) {
        return 'Data is outdated';
    }

    return true;
}
$r = checkTelegramAuth($auth_data);
echo $r;
