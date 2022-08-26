<?php

namespace App\Filters;


use App\Models\Channel;
use App\Models\Task;
use danog\MadelineProto\auth;

class TaskChannelQueryBuilder extends Filter
{
    public function queryResult($query)
    {
        return request('direction') === 'asc' ? $this->orderBy($query) : $this->orderByDesc($query);
    }

    public function byId()
    {
        return $this->orderBy('id', request('direction'));
    }

    public function by_penalty()
    {
        return $this->orderBy('penalty', request('direction'));
    }

    public function by_state()
    {
        return $this->orderBy('state', request('direction'));
    }

    public function by_campaign_id()
    {
        return $this->orderBy('campaign_id', request('direction'));
    }



    public function by_task_title()
    {
        $query = Task::select('title')->whereColumn('tasks.id','task_channels.task_id');
        return $this->queryResult($query);
    }

    public function by_task_silence()
    {
        $query = Task::select('silence')->whereColumn('tasks.id','task_channels.task_id');
        return $this->queryResult($query);
    }

    public function by_task_range_start_at()
    {
        $query = Task::select('range_start_at')->whereColumn('tasks.id','task_channels.task_id');
        return $this->queryResult($query);
    }

    public function by_task_range_end_at()
    {
        $query = Task::select('range_end_at')->whereColumn('tasks.id','task_channels.task_id');
        return $this->queryResult($query);
    }

    public function by_post_nr()
    {
        $query = Task::select('post_nr')->whereColumn('tasks.id','task_channels.task_id');
        return $this->queryResult($query);
    }




    public function by_channel_title()
    {
        $query = Channel::select('title')->whereColumn('channels.id','task_channels.channel_id');
        return $this->queryResult($query);
    }



//
// Предложения от каналов
    public function offers() {
        return $this->orWhereHas('channel', function ($query){
            return $query->where('owner_id', \auth()->id());
        });
    }

    public function own($value) {
        return $this->where('user_id', $value)->orWhereHas('channel', function ($query) use ($value){
            return $query->where('owner_id', $value);
        });
    }

    public function user_id($value) {
        return $this->where('user_id', $value);
    }

    public function task_id($value) {
        return $this->where('task_id', $value);
    }


    public function campaign_id($value) {
        return $this->where('campaign_id',$value);
    }

    public function channel_id($value) {
        return $this->where('channel_id',$value);
    }


}
