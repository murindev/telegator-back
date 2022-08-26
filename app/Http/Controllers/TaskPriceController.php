<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskPriceRequest;
use App\Http\Requests\UpdateTaskPriceRequest;
use App\Models\Task\TaskPrice;

class TaskPriceController extends Controller
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
     * @param  \App\Http\Requests\StoreTaskPriceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskPriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task\TaskPrice  $taskPrice
     * @return \Illuminate\Http\Response
     */
    public function show(TaskPrice $taskPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task\TaskPrice  $taskPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskPrice $taskPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskPriceRequest  $request
     * @param  \App\Models\Task\TaskPrice  $taskPrice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskPriceRequest $request, TaskPrice $taskPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task\TaskPrice  $taskPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskPrice $taskPrice)
    {
        //
    }
}
