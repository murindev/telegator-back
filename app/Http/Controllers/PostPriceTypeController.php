<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostPriceTypeRequest;
use App\Http\Requests\UpdatePostPriceTypeRequest;
use App\Models\Post\PostPriceType;

class PostPriceTypeController extends Controller
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
     * @param  \App\Http\Requests\StorePostPriceTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostPriceTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post\PostPriceType  $postPriceType
     * @return \Illuminate\Http\Response
     */
    public function show(PostPriceType $postPriceType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post\PostPriceType  $postPriceType
     * @return \Illuminate\Http\Response
     */
    public function edit(PostPriceType $postPriceType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostPriceTypeRequest  $request
     * @param  \App\Models\Post\PostPriceType  $postPriceType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostPriceTypeRequest $request, PostPriceType $postPriceType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post\PostPriceType  $postPriceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostPriceType $postPriceType)
    {
        //
    }
}
