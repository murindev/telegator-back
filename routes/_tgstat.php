<?php

use \App\Http\Controllers\Tgstat\TgstatPostsController;

Route::get('posts', [TgstatPostsController::class, 'index']);
Route::get('post/{post_id}', [TgstatPostsController::class, 'show']);
