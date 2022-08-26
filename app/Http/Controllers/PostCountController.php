<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostCountRequest;
use App\Http\Requests\UpdatePostCountRequest;
use App\Models\Statistics\AvgPostCount;

class PostCountController extends Controller
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
     * @param  \App\Http\Requests\StorePostCountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostCountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistics\AvgPostCount  $postCount
     * @return \Illuminate\Http\Response
     */
    public function show(AvgPostCount $postCount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistics\AvgPostCount  $postCount
     * @return \Illuminate\Http\Response
     */
    public function edit(AvgPostCount $postCount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostCountRequest  $request
     * @param  \App\Models\Statistics\AvgPostCount  $postCount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostCountRequest $request, AvgPostCount $postCount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistics\AvgPostCount  $postCount
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvgPostCount $postCount)
    {
        //
    }
}
