<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTgstatViewRequest;
use App\Http\Requests\UpdateTgstatViewRequest;
use App\Models\Tgstat\TgstatView;

class TgstatViewController extends Controller
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
     * @param  \App\Http\Requests\StoreTgstatViewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTgstatViewRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatView  $tgstatView
     * @return \Illuminate\Http\Response
     */
    public function show(TgstatView $tgstatView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatView  $tgstatView
     * @return \Illuminate\Http\Response
     */
    public function edit(TgstatView $tgstatView)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTgstatViewRequest  $request
     * @param  \App\Models\Tgstat\TgstatView  $tgstatView
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTgstatViewRequest $request, TgstatView $tgstatView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tgstat\TgstatView  $tgstatView
     * @return \Illuminate\Http\Response
     */
    public function destroy(TgstatView $tgstatView)
    {
        //
    }
}
