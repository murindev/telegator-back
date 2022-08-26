<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignSaveRequest;
use App\Http\Requests\StoreCampaignChannelRequest;
use App\Models\Campaign;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CampaignController extends Controller
{
    public function index()
    {

    }


    public function updateOrCreate(StoreCampaignChannelRequest $request, Campaign $campaign) {
        return $campaign->updateOrCreateCampaign($request);
    }


    public function show(Campaign $campaign)
    {
        return $campaign->campaignShow();
    }

    public function destroy(Campaign $campaign)
    {
        return $campaign->campaignDestroy();
    }

    public function update(Campaign $campaign)
    {
        return $campaign->campaignUpdate();
    }

    public function userCampaigns(Campaign $campaign) {
        return $campaign->userCampaigns();
    }



    public function create(CampaignSaveRequest $request): JsonResponse
    {
        $model = new Campaign();
        $model->user_id = auth()->id();
        $model->status = 'new';
        $model->version = 1;
        $model->publication = env('PUBLICATION_DURATION_MIN', null);
        $model->silence = env('SILENCE_DURATION_MIN', null);

        return $this->update($request, $model);
    }

    public function update2(CampaignSaveRequest $request, Campaign $campaign): JsonResponse
    {
        $data = $request->validated();

        $campaign->title = $data['title'];
        $campaign->description = $data['description'];
        $campaign->range_start_at = new Carbon($data['range']['start_dts']);
        $campaign->range_end_at = new Carbon($data['range']['end_dts']);

        if ($campaign->exists && $campaign->isDirty()) $campaign->version++;

        $campaign->save();

        return response()->json(['campaign' => $campaign]);
    }

    public function get(Campaign $campaign)
    {
        return $campaign->campaigns();
    }

    public function getOld(Campaign $campaign): JsonResponse
    {
        $campaign->loadMissing(['content', 'tasks.channel.categories']);
        $campaign->tasks->map(function (Task $task) {
            $task->channel->makeVisible([
                'members_count',
                'reach_avg',
                'er',
                'cpu',
                'index',
                'categories_labels'
            ]);
        });

        return response()->json(['campaign' => $campaign]);
    }

    public function search(Request $request): JsonResponse
    {
        $name = $request->input('name', '');
        $type = Str::lower($request->input('type', 'all'));

        $builder = Campaign::where('user_id', \Auth::id());

        if ($name) {
            $builder->where('title', 'like', "%${name}%");
        }

        if (in_array($type, [
            Campaign::STATUS_NEW,
            Campaign::STATUS_ACTIVE,
            Campaign::STATUS_FINISHED
        ])) {
            $builder->where('status', $type);
        }

        return response()->json(['campaigns' => $builder->get()]);
    }

    public function delete(Campaign $campaign): JsonResponse
    {
        if (!$campaign->isNew()) {
            throw ValidationException::withMessages(['campaign' => ['You cannot delete this campaign']]);
        }

        $campaign->delete();

        return response()->json(['result' => 'ok']);
    }

    public function finish(Campaign $campaign): JsonResponse
    {
        // todo: check possibility

        $campaign->status = Campaign::STATUS_FINISHED;
        $campaign->save();
        return response()->json(['campaign' => $campaign]);
    }
}
