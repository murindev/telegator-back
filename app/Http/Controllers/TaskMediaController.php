<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskMediaRequest;
use App\Http\Requests\UpdateTaskMediaRequest;
use App\Models\Task\TaskMedia;

class TaskMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreTaskMediaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskMediaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task\TaskMedia  $taskMedia
     * @return \Illuminate\Http\Response
     */
    public function show(TaskMedia $taskMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task\TaskMedia  $taskMedia
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskMedia $taskMedia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskMediaRequest  $request
     * @param  \App\Models\Task\TaskMedia  $taskMedia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskMediaRequest $request, TaskMedia $taskMedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task\TaskMedia  $taskMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskMedia $taskMedia)
    {
        //
    }
}
