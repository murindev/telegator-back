<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostPriceRequest;
use App\Http\Requests\UpdatePostPriceRequest;
use App\Models\Post\PostPrice;

class PostPriceController extends Controller
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
     * @param  \App\Http\Requests\StorePostPriceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostPriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post\PostPrice  $postPrice
     * @return \Illuminate\Http\Response
     */
    public function show(PostPrice $postPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post\PostPrice  $postPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(PostPrice $postPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostPriceRequest  $request
     * @param  \App\Models\Post\PostPrice  $postPrice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostPriceRequest $request, PostPrice $postPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post\PostPrice  $postPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostPrice $postPrice)
    {
        //
    }
}
