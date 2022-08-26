<?php

use App\Http\Controllers\Api\TaskController;
Route::post('index',[TaskController::class,'index']);
Route::post('create', [TaskController::class, 'create']);
Route::get('show', [TaskController::class, 'show']);
Route::get('userTasks', [TaskController::class, 'userTasks']);
Route::get('allTasks', [TaskController::class, 'allTasks']);



//Route::post('create/from/{campaign}/to/{channel}', [TaskController::class, 'create']);
//    ->middleware('can:update,campaign');
//Route::post('create/from/{campaign}/to', [TaskController::class, 'createMany']);
//    ->middleware('can:update,campaign');
//Route::post('invite/{task}', [TaskController::class, 'invite']);
//    ->middleware('can:update,task');
//Route::post('invite/from/{campaign}/to', [TaskController::class, 'inviteMany']);
//    ->middleware('can:update,campaign');
//Route::get('list', [TaskController::class, 'list']);
