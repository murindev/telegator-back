<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TelegramUser;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\TelegramBot\TGBot;
use App\Utils\Generator;
use App\Utils\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TelegramAuthController extends Controller
{
    public function auth(Request $request, AuthService $authService): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            "auth_date" => ['required', 'integer'],
            "id" => ['required', 'integer'],
            "hash" => ['required', 'string'],
            "first_name" => ['string'],
            "last_name" => ['string'],
            "username" => ['string'],
            "photo_url" => ['string'],
        ]);

        $this->checkTelegramAuth($data);


        $tgUser = TelegramUser::find($data['id']) ?: $this->createTelegramUser($data);
//        return response()->json($tgUser);

        if (!Auth::check()) {
            Auth::login($tgUser->user, true);
            $request->session()->regenerate();
        }


        return response()->json([
            'token' => $authService->getAuthToken(\auth()->user())
        ]);
    }

    public function delete()
    {
        $user = Auth::user();

        if (!$user->telegram) {
            throw ValidationException::withMessages(['telegram' => ['Nothing to do']]);
        }

        $telegram = $user->telegram;
        $telegram->delete();
        $user->refresh();

        response()->json(['user' => $user]);
    }

    protected function createTelegramUser($auth_data): TelegramUser
    {
        $tgUser = new TelegramUser();
        $tgUser->fillFillable($auth_data);
        $tgUser->id = $auth_data['id'];
        $tgUser->have_photo = isset($auth_data['photo_url']) ? Str::startsWith($auth_data['photo_url'], 'https://t.me/i/userpic/') : 0;

        if (Auth::check()) {
            $tgUser->user_id = Auth::id();
        } else {
            $user = User::create([
                'name' => $tgUser->first_name,
                'email' => Generator::emailDummy(),
                'password' => '-',
                'api_token' => Str::random(80),
            ]);

            $tgUser->user_id = $user->id;
        }

        if ($tgUser->have_photo && !$tgUser->user->avatar) {
            $user = $tgUser->user;
            $user->avatar = Helper::storePublicFile(
                $auth_data['photo_url'],
                'avatars/users/' . Str::random(6) . '/' . Str::random(6)
            );
            $user->save();
        }

        $tgUser->push();

        return $tgUser;
    }

    protected function checkTelegramAuth(array $auth_data)
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
            throw ValidationException::withMessages(['auth' => ['Data is NOT from Telegram']]);
        }
        if ((time() - $auth_data['auth_date']) > 86400) {
            throw ValidationException::withMessages(['auth' => ['Data is outdated']]);
        }
    }
}
