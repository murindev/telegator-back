<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCampaignChannelRequest;
use App\Http\Requests\UpdateCampaignChannelRequest;
use App\Models\Campaign\CampaignChannel;

class CampaignChannelController extends Controller
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
     * @param  \App\Http\Requests\StoreCampaignChannelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignChannelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign\CampaignChannel  $campaignChannel
     * @return \Illuminate\Http\Response
     */
    public function show(CampaignChannel $campaignChannel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign\CampaignChannel  $campaignChannel
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaignChannel $campaignChannel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCampaignChannelRequest  $request
     * @param  \App\Models\Campaign\CampaignChannel  $campaignChannel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCampaignChannelRequest $request, CampaignChannel $campaignChannel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign\CampaignChannel  $campaignChannel
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignChannel $campaignChannel)
    {
        //
    }
}
