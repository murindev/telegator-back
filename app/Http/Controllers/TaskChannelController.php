<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskChannelRequest;
use App\Http\Requests\UpdateTaskChannelRequest;
use App\Models\Task\TaskChannel;

class TaskChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TaskChannel $taskChannel)
    {
        return $taskChannel->taskChannelsIndex();
    }

    public function paginate(TaskChannel $taskChannel)
    {
        return $taskChannel->taskChannelsPaginate();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskChannelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskChannelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task\TaskChannel  $taskChannel
     * @return TaskChannel|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\Response|object
     */
    public function show(TaskChannel $taskChannel)
    {
        return $taskChannel->with($taskChannel->getRelations())->where('id',request('id'))->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task\TaskChannel  $taskChannel
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskChannel $taskChannel)
    {
        //
    }

    /**
     * Update the specified resource in storage
     */
    public function update(UpdateTaskChannelRequest $request, TaskChannel $taskChannel)
    {
        return $taskChannel->taskChannelUpdateOrCreate($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task\TaskChannel  $taskChannel
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskChannel $taskChannel)
    {
        //
    }
}
