<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvgCitingRequest;
use App\Http\Requests\UpdateAvgCitingRequest;
use App\Models\Statistics\AvgCiting;

class AvgCitingController extends Controller
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
     * @param  \App\Http\Requests\StoreAvgCitingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvgCitingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistics\AvgCiting  $avgCiting
     * @return \Illuminate\Http\Response
     */
    public function show(AvgCiting $avgCiting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistics\AvgCiting  $avgCiting
     * @return \Illuminate\Http\Response
     */
    public function edit(AvgCiting $avgCiting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAvgCitingRequest  $request
     * @param  \App\Models\Statistics\AvgCiting  $avgCiting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvgCitingRequest $request, AvgCiting $avgCiting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistics\AvgCiting  $avgCiting
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvgCiting $avgCiting)
    {
        //
    }
}
