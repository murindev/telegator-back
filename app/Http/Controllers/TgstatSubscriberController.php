<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTgstatSubscriberRequest;
use App\Http\Requests\UpdateTgstatSubscriberRequest;
use App\Models\Tgstat\TgstatSubscriber;

class TgstatSubscriberController extends Controller
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
     * @param  \App\Http\Requests\StoreTgstatSubscriberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTgstatSubscriberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatSubscriber  $tgstatSubscriber
     * @return \Illuminate\Http\Response
     */
    public function show(TgstatSubscriber $tgstatSubscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatSubscriber  $tgstatSubscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(TgstatSubscriber $tgstatSubscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTgstatSubscriberRequest  $request
     * @param  \App\Models\Tgstat\TgstatSubscriber  $tgstatSubscriber
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTgstatSubscriberRequest $request, TgstatSubscriber $tgstatSubscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tgstat\TgstatSubscriber  $tgstatSubscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(TgstatSubscriber $tgstatSubscriber)
    {
        //
    }
}
