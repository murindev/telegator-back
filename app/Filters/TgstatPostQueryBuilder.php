<?php

namespace App\Filters;

use App\Models\Tgstat\TgstatPostsStat;

class TgstatPostQueryBuilder extends Filter
{
    public function queryResult($query)
    {
        return request('direction') === 'asc' ? $this->orderBy($query) : $this->orderByDesc($query);
    }

    public function byId()
    {
        return $this->orderBy('id', request('direction'));
    }

    public function by_text()
    {
        return $this->orderBy('text', request('direction'));
    }

    public function by_date()
    {
        return $this->orderBy('date', request('direction'));
    }

    public function by_views()
    {
        return $this->orderBy('views', request('direction'));
    }

    public function by_forwards() {
        $query = TgstatPostsStat::select('forwards_count')->whereColumn('tgstat_posts_stats.post_id','tgstat_posts.post_id');
        return $this->queryResult($query);
    }



}
