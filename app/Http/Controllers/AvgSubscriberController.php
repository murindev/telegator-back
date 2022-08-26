<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvgSubscriberRequest;
use App\Http\Requests\UpdateAvgSubscriberRequest;
use App\Models\Statistics\AvgSubscriber;

class AvgSubscriberController extends Controller
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
     * @param  \App\Http\Requests\StoreAvgSubscriberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvgSubscriberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistics\AvgSubscriber  $avgSubscriber
     * @return \Illuminate\Http\Response
     */
    public function show(AvgSubscriber $avgSubscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistics\AvgSubscriber  $avgSubscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(AvgSubscriber $avgSubscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAvgSubscriberRequest  $request
     * @param  \App\Models\Statistics\AvgSubscriber  $avgSubscriber
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvgSubscriberRequest $request, AvgSubscriber $avgSubscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistics\AvgSubscriber  $avgSubscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvgSubscriber $avgSubscriber)
    {
        //
    }
}
