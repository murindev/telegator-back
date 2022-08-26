<?php

namespace App\Filters;


class PostQueryBuilder extends Filter
{

    public function byTitle()
    {
        return $this->orderBy('title', request('direction'));
    }

    public function byId()
    {
        return $this->orderBy('id', request('direction'));
    }

    public function byCreatedAt()
    {
        return $this->orderBy('created_at', request('direction'));
    }

    public function byViewsCnt()
    {
        return $this->orderBy('views_cnt', request('direction'));
    }

    public function byForwardsCnt()
    {
        return $this->orderBy('forwards_cnt', request('direction'));
    }

    public function byIsAdvert()
    {
        return $this->orderBy('is_advert', request('direction'));
    }



}
