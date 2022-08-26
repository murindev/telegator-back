<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTgstatStatRequest;
use App\Http\Requests\UpdateTgstatStatRequest;
use App\Models\Tgstat\TgstatStat;

class TgstatStatController extends Controller
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
     * @param  \App\Http\Requests\StoreTgstatStatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTgstatStatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatStat  $tgstatStat
     * @return \Illuminate\Http\Response
     */
    public function show(TgstatStat $tgstatStat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatStat  $tgstatStat
     * @return \Illuminate\Http\Response
     */
    public function edit(TgstatStat $tgstatStat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTgstatStatRequest  $request
     * @param  \App\Models\Tgstat\TgstatStat  $tgstatStat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTgstatStatRequest $request, TgstatStat $tgstatStat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tgstat\TgstatStat  $tgstatStat
     * @return \Illuminate\Http\Response
     */
    public function destroy(TgstatStat $tgstatStat)
    {
        //
    }
}
