<?php

use App\Http\Controllers\Api\ChannelController;

Route::get('index', [ChannelController::class,'index']);
Route::get('byOwner', [ChannelController::class,'byOwner']);
Route::get('categories', [ChannelController::class,'categories']);


Route::get('/{id}', [ChannelController::class, 'getChannel']);
Route::post('claim', [ChannelController::class, 'claim']);
Route::get('list', [ChannelController::class, '_list']);
Route::post('search', [ChannelController::class, 'search']);

Route::group(['prefix' => 'post'], function () {
    Route::get('index', [\App\Http\Controllers\PostController::class, 'index']);
    Route::get('show', [\App\Http\Controllers\PostController::class, 'show']);
    Route::get('with-views', [\App\Http\Controllers\PostController::class, 'showWithViews']);
});
