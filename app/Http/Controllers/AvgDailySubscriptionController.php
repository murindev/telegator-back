<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvgDailySubscriptionRequest;
use App\Http\Requests\UpdateAvgDailySubscriptionRequest;
use App\Models\Statistics\AvgDailySubscription;

class AvgDailySubscriptionController extends Controller
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
     * @param  \App\Http\Requests\StoreAvgDailySubscriptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvgDailySubscriptionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistics\AvgDailySubscription  $avgDailySubscription
     * @return \Illuminate\Http\Response
     */
    public function show(AvgDailySubscription $avgDailySubscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistics\AvgDailySubscription  $avgDailySubscription
     * @return \Illuminate\Http\Response
     */
    public function edit(AvgDailySubscription $avgDailySubscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAvgDailySubscriptionRequest  $request
     * @param  \App\Models\Statistics\AvgDailySubscription  $avgDailySubscription
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvgDailySubscriptionRequest $request, AvgDailySubscription $avgDailySubscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistics\AvgDailySubscription  $avgDailySubscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvgDailySubscription $avgDailySubscription)
    {
        //
    }
}
