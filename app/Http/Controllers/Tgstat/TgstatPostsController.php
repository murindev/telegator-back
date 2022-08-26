<?php

namespace App\Http\Controllers\Tgstat;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTgstatPostsRequest;
use App\Http\Requests\UpdateTgstatPostsRequest;
use App\Models\Tgstat\TgstatPost;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TgstatPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TgstatPost $tgstatPost)
    {
        return $tgstatPost->index();
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
     * @param \App\Http\Requests\StoreTgstatPostsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTgstatPostsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param TgstatPost $tgstatPosts
     * @param $post_id
     * @return TgstatPost
     */
    public function show(TgstatPost $tgstatPosts, $post_id): TgstatPost
    {
        return $tgstatPosts->show($post_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Tgstat\TgstatPost $tgstatPosts
     * @return \Illuminate\Http\Response
     */
    public function edit(TgstatPost $tgstatPosts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTgstatPostsRequest $request
     * @param \App\Models\Tgstat\TgstatPost $tgstatPosts
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTgstatPostsRequest $request, TgstatPost $tgstatPosts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tgstat\TgstatPost $tgstatPosts
     * @return \Illuminate\Http\Response
     */
    public function destroy(TgstatPost $tgstatPosts)
    {
        //https://gitlab.com/telegram-observer/web-app  https://gitlab.com/telegram-observer/web-app.git
    }
}
