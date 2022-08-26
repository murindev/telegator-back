<?php

namespace App\Filters;

class CampaignQueryBuilder extends Filter
{

    public function byId() {
        return $this->orderBy('id', request('direction'));
    }
    public function byTitle() {
        return $this->orderBy('title', request('direction'));
    }
    public function byRangeStartAt() {
        return $this->orderBy('range_start_at', request('direction'));
    }
    public function byRangeEndAt() {
        return $this->orderBy('range_end_at', request('direction'));
    }


    public function title($value){
        return $this->where('title','like', '%'.$value.'%');
    }

    public function status($value){
        return $this->where('status',$value);
    }

    public function user_id($value){
        return $this->where('user_id',$value);
    }



}
