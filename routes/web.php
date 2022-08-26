<?php

use App\Http\Controllers\Api\TelegramAuthController;
use App\Http\Middleware\ForceJsonResponse;
use App\Services\TelegramBot\TGBot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Parse\StatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['namespace'=>'Api', 'prefix' => 'api/auth', 'middleware' => [ForceJsonResponse::class]], function () {

    Route::get('/info', [AuthController::class, 'info']);

    Route::post('/forgot-password', [AuthController::class, 'forgot']);
    Route::get('/reset-password', function (){
        return redirect()->to(config('app.front_url').'/reset-password?'.request()->getQueryString());
    })->name('password.reset');
    Route::post('/reset', [AuthController::class, 'reset']);

    Route::post('/set-email', [AuthController::class, 'setEmail'])->middleware('auth');
    Route::post('/change-email', [AuthController::class, 'changeEmail'])->middleware('auth');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

    Route::post('/tg-auth', [TelegramAuthController::class, 'auth']);

    Route::get('/tg-delete', [TelegramAuthController::class, 'delete'])->middleware('auth');

    Route::get('/tt', function (\App\Models\Channel $channel){


       $uu = TGBot::sendMessageByChannelId(282,'Вашему каналу предложили выполнить задачу в сервисе Telegator');
       dump($uu);



    });

});

