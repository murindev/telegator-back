<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvgPostViewRequest;
use App\Http\Requests\UpdateAvgPostViewRequest;
use App\Models\Statistics\AvgPostView;

class AvgPostViewController extends Controller
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
     * @param  \App\Http\Requests\StoreAvgPostViewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvgPostViewRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistics\AvgPostView  $avgPostView
     * @return \Illuminate\Http\Response
     */
    public function show(AvgPostView $avgPostView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistics\AvgPostView  $avgPostView
     * @return \Illuminate\Http\Response
     */
    public function edit(AvgPostView $avgPostView)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAvgPostViewRequest  $request
     * @param  \App\Models\Statistics\AvgPostView  $avgPostView
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvgPostViewRequest $request, AvgPostView $avgPostView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistics\AvgPostView  $avgPostView
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvgPostView $avgPostView)
    {
        //
    }
}
