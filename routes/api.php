<?php

use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Parse\StatController;
use App\Http\Middleware\ForceJsonResponse;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Helpers
Route::group(['prefix' => 'helpers'], function () {
    Route::any('trans', function (Request $request) {
        response()->json(['request' => $request->toArray()]);
    });
    Route::post('upload', [TestController::class, 'upload']);
    Route::post('combine', [TestController::class, 'combine']);
    Route::get('constants/{section}', [TestController::class, 'constants']);
});

Route::middleware(['auth:api', ForceJsonResponse::class])->group(function () {

    //User
    Route::group(['prefix' => 'user'], function (){
        Route::get('info', [UserController::class,'info']);
        Route::post('balance', [UserController::class,'balance']);
    });

    // Channel
    Route::group(['prefix' => 'channel'], function () {
        include '_channels.php';
    });

    Route::group(['prefix' => 'parse'], function (){
        Route::post('stat', [StatController::class,'init']);
    });


    // Campaign

    Route::group(['prefix' => 'campaign'], function () {

        include "_campaigns.php";

    });

    // Category
    Route::group(['prefix' => 'category'], function () {
        Route::get('list', function () {
            return response()->json(['categories' => Category::all()]);
        });
    });

    // Category
    Route::group(['prefix' => 'channels'], function () {
        Route::get('/', [ChannelController::class, 'getAll']);
        Route::post('/', [ChannelController::class, 'add']);
    });

    // Task
    Route::group(['prefix' => 'task'], function () {
        include '_tasks.php';
    });

    // TaskChannels
    Route::group(['prefix' => 'task-channels'], function () {
        include '_task_channels.php';
    });

    // TgStat
    Route::group(['prefix' => 'tgstat'], function () {
        include '_tgstat.php';
    });

    // test
    Route::group(['prefix' => 'test'], function () {
        Route::get('parseHttpTg', [ChannelController::class, 'parseHttpTg']);
    });


});


Route::group(['namespace'=>'Api', 'prefix' => 'auth'], function () {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/login', [AuthController::class, 'login']);
});
