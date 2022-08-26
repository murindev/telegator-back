<?php

namespace App\Filters;

class TaskQueryBuilder extends Filter
{
    public function queryResult($query)
    {
        return request('direction') === 'asc' ? $this->orderBy($query) : $this->orderByDesc($query);
    }


    public function byId()
    {
        return $this->orderBy('id', request('direction'));
    }

    public function byTitle()
    {
        return $this->orderBy('title', request('direction'));
    }


    public function user_id($value) {
        return $this->where('user_id',$value);
    }

    public function title($value) {
        return $this->where('title','like', '%'.$value.'%');
    }



}
