<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvgErrRequest;
use App\Http\Requests\UpdateAvgErrRequest;
use App\Models\Statistics\AvgErr;

class AvgErrController extends Controller
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
     * @param  \App\Http\Requests\StoreAvgErrRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvgErrRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistics\AvgErr  $avgErr
     * @return \Illuminate\Http\Response
     */
    public function show(AvgErr $avgErr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistics\AvgErr  $avgErr
     * @return \Illuminate\Http\Response
     */
    public function edit(AvgErr $avgErr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAvgErrRequest  $request
     * @param  \App\Models\Statistics\AvgErr  $avgErr
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvgErrRequest $request, AvgErr $avgErr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistics\AvgErr  $avgErr
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvgErr $avgErr)
    {
        //
    }
}
