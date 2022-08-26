<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostViewRequest;
use App\Http\Requests\UpdatePostViewRequest;
use App\Models\Post\PostView;

class PostViewController extends Controller
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
     * @param  \App\Http\Requests\StorePostViewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostViewRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post\PostView  $postView
     * @return \Illuminate\Http\Response
     */
    public function show(PostView $postView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post\PostView  $postView
     * @return \Illuminate\Http\Response
     */
    public function edit(PostView $postView)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostViewRequest  $request
     * @param  \App\Models\Post\PostView  $postView
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostViewRequest $request, PostView $postView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post\PostView  $postView
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostView $postView)
    {
        //
    }
}
