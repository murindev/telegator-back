<?php

use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CampaignContentController;

// campaign

Route::post('save', [CampaignController::class, 'updateOrCreate']);
//    ->middleware('can:create,App\Models\Campaign');

Route::get('get', [CampaignController::class, 'get']);
//    ->middleware('can:view,campaign');

Route::get('show', [CampaignController::class, 'show']);
//    ->middleware('can:view,campaign');

Route::get('destroy', [CampaignController::class, 'destroy']);
//    ->middleware('can:view,campaign');

Route::post('update', [CampaignController::class, 'update']);
//    ->middleware('can:view,campaign');


Route::get('user-campaigns', [CampaignController::class, 'userCampaigns']);





Route::get('{campaign}', [CampaignController::class, 'get'])
    ->middleware('can:view,campaign');






Route::get('{campaign}/old_version', function (Campaign $campaign) {
    $campaign->content;
    return response()->json(['campaign' => $campaign]);
})->middleware('can:view,campaign');

Route::post('search', [CampaignController::class, 'search']);



Route::post('save/{campaign}', [CampaignController::class, 'update'])->middleware('can:update,campaign');

Route::post('delete/{campaign}', [CampaignController::class, 'delete'])->middleware('can:delete,campaign');

Route::post('finish/{campaign}', [CampaignController::class, 'finish'])->middleware('can:update,campaign');

Route::post('content/{campaign}', [CampaignContentController::class, 'save'])->middleware('can:update,campaign');

