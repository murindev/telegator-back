<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvgAdvertViewRequest;
use App\Http\Requests\UpdateAvgAdvertViewRequest;
use App\Models\Statistics\AvgAdvertView;

class AvgAdvertViewController extends Controller
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
     * @param  \App\Http\Requests\StoreAvgAdvertViewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvgAdvertViewRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistics\AvgAdvertView  $avgAdvertView
     * @return \Illuminate\Http\Response
     */
    public function show(AvgAdvertView $avgAdvertView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistics\AvgAdvertView  $avgAdvertView
     * @return \Illuminate\Http\Response
     */
    public function edit(AvgAdvertView $avgAdvertView)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAvgAdvertViewRequest  $request
     * @param  \App\Models\Statistics\AvgAdvertView  $avgAdvertView
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvgAdvertViewRequest $request, AvgAdvertView $avgAdvertView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistics\AvgAdvertView  $avgAdvertView
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvgAdvertView $avgAdvertView)
    {
        //
    }
}
