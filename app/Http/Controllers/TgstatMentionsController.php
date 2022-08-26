<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTgstatMentionsRequest;
use App\Http\Requests\UpdateTgstatMentionsRequest;
use App\Models\Tgstat\TgstatMention;

class TgstatMentionsController extends Controller
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
     * @param  \App\Http\Requests\StoreTgstatMentionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTgstatMentionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatMention  $tgstatMentions
     * @return \Illuminate\Http\Response
     */
    public function show(TgstatMention $tgstatMentions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tgstat\TgstatMention  $tgstatMentions
     * @return \Illuminate\Http\Response
     */
    public function edit(TgstatMention $tgstatMentions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTgstatMentionsRequest  $request
     * @param  \App\Models\Tgstat\TgstatMention  $tgstatMentions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTgstatMentionsRequest $request, TgstatMention $tgstatMentions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tgstat\TgstatMention  $tgstatMentions
     * @return \Illuminate\Http\Response
     */
    public function destroy(TgstatMention $tgstatMentions)
    {
        //
    }
}
