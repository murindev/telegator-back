<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignContentController extends Controller
{
    public function save(Request $request, Campaign $campaign): JsonResponse
    {
        $data = $request->validate([
            'messageHtml'   => ['required', 'string'],
            'messageMarked' => ['required', 'string'],
            'media'         => [function($attribute, $value, $fail) {
                if (method_exists($value, 'getMimeType')) {
                    $mt = $value->getMimeType();
                    if (!Str::startsWith($mt, ['video', 'image'])) {
                        $fail("$attribute must be video or image");
                    }
                }
            }]
        ]);

        $model = $campaign->content;

        $model->message     = $data['messageMarked'];
        $model->message_raw = $data['messageHtml'];

        if (!$model->exists) {
            $model->with_video = false;
            $model->with_image = false;
            $model->link       = null;
        }

        $campaign_id = $campaign->id;

        if ($file = $request->file('media')) {
            $fileInfo = [
                'name'      => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size'      => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ];

            $path = "content/${campaign_id}/" . str_replace(' ', '_', $fileInfo['name']);

            if ($stored = Storage::disk('public')->putFile($path, $file))
            {
                $model->with_image = Str::startsWith($fileInfo['mime_type'], 'image');
                $model->with_video = Str::startsWith($fileInfo['mime_type'], 'video');
                $model->link = Storage::url($stored);
            } else {
                return response()->json()->withException(new \Exception('Can not store file'));
            }
        }

        $model->save();

        return response()->json(['campaign_content' => $model]);
    }

}
