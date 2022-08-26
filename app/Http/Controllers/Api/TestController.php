<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CampaignSaveRequest;
use App\Services\MemoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController
{
    public function upload(Request $request): JsonResponse
    {
        $data = $request->validate(['file' => '']);
        $res  = ['result' => 'ok'];

        if ($file = $request->file('file')) {

            $fileInfo = [
                'name'      => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size'      => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ];

            $path  = 'test/' . str_replace(' ', '_', $fileInfo['name']);
            $store = Storage::disk('public')->putFile($path, $file);
            $url   = Storage::url($store);

            $res += ['info' => $fileInfo, 'path' => $path, 'store' => $store, 'url' => $url,];
        }

        return response()->json($res);
    }

    public function constants($section = 'auth'): JsonResponse
    {
        $config = config('telegator');

        abort_unless(key_exists($section, $config), 404);

        return response()->json(['constants' => $config[$section]]);
    }

    public function combine(CampaignSaveRequest $request): JsonResponse
    {
        $data = $request->validated();

        return response()->json([
            'dump' => app()->make(MemoryService::class)->dump(),
            'data' => $data,
            'acc'  => $data['range.start_dts']
        ]);
    }
}
