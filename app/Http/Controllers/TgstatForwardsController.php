<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTgstatForwardsRequest;
use App\Http\Requests\UpdateTgstatForwardsRequest;
use App\Models\Tgstat\TgstatForward;

class TgstatForwardsController extends Controller
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
     * @param  \App\Http\Requests\StoreTgstatForwardsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTgstatForwardsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatForward  $tgstatForwards
     * @return \Illuminate\Http\Response
     */
    public function show(TgstatForward $tgstatForwards)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatForward  $tgstatForwards
     * @return \Illuminate\Http\Response
     */
    public function edit(TgstatForward $tgstatForwards)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTgstatForwardsRequest  $request
     * @param  \App\Models\Tgstat\TgstatForward  $tgstatForwards
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTgstatForwardsRequest $request, TgstatForward $tgstatForwards)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tgstat\TgstatForward  $tgstatForwards
     * @return \Illuminate\Http\Response
     */
    public function destroy(TgstatForward $tgstatForwards)
    {
        //
    }
}
