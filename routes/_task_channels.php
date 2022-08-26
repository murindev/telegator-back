<?php
use \App\Http\Controllers\TaskChannelController;


Route::post('index', [TaskChannelController::class, 'index']);
Route::post('paginate', [TaskChannelController::class, 'paginate']);
Route::get('show', [TaskChannelController::class, 'show']);
Route::post('update', [TaskChannelController::class, 'update']);
