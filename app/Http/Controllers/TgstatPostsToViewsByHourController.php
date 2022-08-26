<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTgstatPostsToViewsByHourRequest;
use App\Http\Requests\UpdateTgstatPostsToViewsByHourRequest;
use App\Models\Tgstat\TgstatPostsToViewsByHour;

class TgstatPostsToViewsByHourController extends Controller
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
     * @param  \App\Http\Requests\StoreTgstatPostsToViewsByHourRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTgstatPostsToViewsByHourRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatPostsToViewsByHour  $tgstatPostsToViewsByHour
     * @return \Illuminate\Http\Response
     */
    public function show(TgstatPostsToViewsByHour $tgstatPostsToViewsByHour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatPostsToViewsByHour  $tgstatPostsToViewsByHour
     * @return \Illuminate\Http\Response
     */
    public function edit(TgstatPostsToViewsByHour $tgstatPostsToViewsByHour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTgstatPostsToViewsByHourRequest  $request
     * @param  \App\Models\Tgstat\TgstatPostsToViewsByHour  $tgstatPostsToViewsByHour
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTgstatPostsToViewsByHourRequest $request, TgstatPostsToViewsByHour $tgstatPostsToViewsByHour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tgstat\TgstatPostsToViewsByHour  $tgstatPostsToViewsByHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(TgstatPostsToViewsByHour $tgstatPostsToViewsByHour)
    {
        //
    }
}
