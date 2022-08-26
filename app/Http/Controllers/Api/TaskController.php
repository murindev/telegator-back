<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskPriceRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Campaign;
use App\Models\Channel;
use App\Models\Task;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Task $task) {
        return $task->index();
    }


    public function userTasks(Task $task) {
        return $task->userTasks();
    }

    public function allTasks(Task $task) {
        return $task->allTasks();
    }

    public function create(StoreTaskRequest $request, Task $task){
//        return $request;
        return $task->createTask($request);
    }


    public function show(Task $task) {
        return $task->where('id',\request('id'))->with(['campaign','channels','content','media','prices'])->first();
    }


    ////////////////////////////////////

    public function create2(Campaign $campaign, Channel $channel): JsonResponse
    {
        if (Task::where([
            'campaign_id' => $campaign->id,
            'channel_id'  => $channel->id
        ])->first()) {
            // duplicate
            throw ValidationException::withMessages(['task' => ['duplicate task']]);
        }

        $task = new Task();
        $task->campaign_id = $campaign->id;
        $task->channel_id  = $channel->id;

        $task->status  = Task::STATUS_NEW;
        $task->migrate();
        $task->push();

        return response()->json(['task' => $task]);
    }

    public function createMany(Request $request, Campaign $campaign): JsonResponse
    {
        $data  = $request->validate([
            'channelIds'   => ['required', 'array'],
            'channelIds.*' => ['integer']
        ]);
        $tasks = [];

        foreach ($data['channelIds'] as $channelId) {
            $channel = Channel::findOrFail($channelId);

            $task = new Task();
            $task->campaign_id = $campaign->id;
            $task->channel_id  = $channel->id;

            $task->status  = Task::STATUS_NEW;
            $task->migrate();
            $task->push();

            $tasks[] = $task;
        }

        return response()->json(['tasks' => $tasks]);
    }

    public function invite(Task $task): JsonResponse
    {
        if (! $task->campaign->ableToAssign()) {
            throw ValidationException::withMessages(['task' => ['Invalid campaign']]);
        }

        if ($task->campaign->isNew()) $task->campaign->status = Campaign::STATUS_ACTIVE;

        $task->status  = Task::STATUS_INVITED;
        $task->migrate();
        $task->push();

        // todo Real invite

        return response()->json(['task' => $task]);
    }

    public function inviteMany(Request $request, Campaign $campaign): JsonResponse
    {
        $data  = $request->validate([
            'taskIds'   => ['required', 'array'],
            'taskIds.*' => ['integer']
        ]);
        $tasks = [];

        if (! $campaign->ableToAssign()) {
            throw ValidationException::withMessages(['task' => ['Invalid campaign']]);
        }

        foreach ($data['taskIds'] as $taskId) {
            $task = Task::findOrFail($taskId);

            if ($task->campaign_id !== $campaign->id) continue;

            $task->status  = Task::STATUS_INVITED;
            $task->migrate();
            $task->push();

            // todo Real invite

            $tasks[] = $task;
        }

        if ($campaign->isNew()) {
            $campaign->status = Campaign::STATUS_ACTIVE;
            $campaign->save();
        }

        return response()->json(['tasks' => $tasks]);
    }

    public function list(): JsonResponse
    {
        return response()->json(['tasks' => []]);
    }
}
