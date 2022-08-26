<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvgSexRequest;
use App\Http\Requests\UpdateAvgSexRequest;
use App\Models\Statistics\AvgSex;

class AvgSexController extends Controller
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
     * @param  \App\Http\Requests\StoreAvgSexRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvgSexRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistics\AvgSex  $avgSex
     * @return \Illuminate\Http\Response
     */
    public function show(AvgSex $avgSex)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistics\AvgSex  $avgSex
     * @return \Illuminate\Http\Response
     */
    public function edit(AvgSex $avgSex)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAvgSexRequest  $request
     * @param  \App\Models\Statistics\AvgSex  $avgSex
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvgSexRequest $request, AvgSex $avgSex)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistics\AvgSex  $avgSex
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvgSex $avgSex)
    {
        //
    }
}
