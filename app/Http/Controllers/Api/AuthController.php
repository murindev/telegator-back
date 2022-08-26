<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistryRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function info(Request $request)
    {
        $guard = Auth::guard();

        return response()->json(
            $guard->check() ?
                ['user' => $guard->user()] :
                ['error' => 'unauthorized']
        );
    }

    public function signup(RegistryRequest $request, AuthService $authService, User $userModel)
    {
        $user = $userModel->createUser($request->email, $request->password, $request->name);

        event(new Registered($user));

        return response()->json(['user' => $user, 'token' => $authService->getAuthToken($user)]);
    }

    public function setEmail(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:' . config('telegator.auth.password_min_length'),
        ]);

        $user = Auth::user();
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        event(new Registered($user));

        return response()->json(['user' => $user]);
    }

    public function changeEmail(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:' . config('telegator.auth.password_min_length'),
        ]);

        if (!Hash::check($data['password'], Auth::user()->getAuthPassword())) {
            throw ValidationException::withMessages(['password' => ['Wrong password']]);
        }

        $user = Auth::user();
        $user->email = $data['email'];
        $user->save();

        return response()->json(['user' => $user]);
    }

    public function login(LoginRequest $request, AuthService $authService)
    {

        $loginData = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($loginData)) {
            $user = auth()->user();

            $accessToken = $authService->getAuthToken($user);

            return response()->json([
                'token' => $accessToken
            ]);
        }

        return response()->json(
            [
                'message' => 'Введены неверные данные.',
                'errors' => ['email' =>
                    ['Неверный email или пароль. Пожалуйста введите верные данные.']
                ],
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        response()->json('ok');
    }

    public function forgot(Request $request)
    {

        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $validator = \Validator::make($input, $rules);


        if ($validator->fails()) {
            return \Response::json(array("status" => 400, "message" => $validator->errors()->first(), "data" => array()));
        } else {
            try {
                $response = Password::sendResetLink($request->only('email'));
                switch ($response) {
                    case Password::RESET_LINK_SENT:
                        return \Response::json(array("status" => 200, "message" => trans($response), "data" => array()));
                    case Password::INVALID_USER:
                        return \Response::json(array("status" => 400, "message" => trans($response), "data" => array()));
                }
            } catch (\Swift_TransportException|\Exception $ex) {
                return \Response::json(array("status" => 400, "message" => $ex->getMessage(), "data" => []));
            }
        }
    }

    public function reset(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(array("status" => 200, "message" => trans($status), "data" => array()))
            : response()->json(back()->withErrors(['email' => [__($status)]]));

    }

}
