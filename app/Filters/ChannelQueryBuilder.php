<?php

namespace App\Filters;

use App\Models\Category;
use App\Models\ChannelCategories;
use App\Models\Statistics\AvgPostView;
use App\Models\Statistics\AvgSubscriber;
use App\Models\Tgstat\TgstatStat;

class ChannelQueryBuilder extends Filter
{

    public function byTitle()
    {
        return $this->orderBy('title', request('direction'));
    }

    public function byId()
    {
        return $this->orderBy('id', request('direction'));
    }

    public function byPrice()
    {
        return $this->orderBy('price', request('direction'));
    }

    public function bySubscribers(): ChannelQueryBuilder
    {

        $query = AvgSubscriber::select('total')->whereColumn('avg_subscribers.channel_id', 'channels.id');
        return $this->queryResult($query);

    }

    public function byCategories()
    {
        $query = ChannelCategories::select('category_id')->whereColumn('category_channel.channel_id', 'channels.id')
            ->latest('category_id')->limit(1);
        return $this->queryResult($query);
    }

    public function by_avg_post_reach()
    {
        $query = TgstatStat::select('avg_post_reach')->whereColumn('tgstat_stats.channel_id', 'channels.id');
        return $this->queryResult($query);
    }

    public function by_err_percent()
    {
        $query = TgstatStat::select('err_percent')->whereColumn('tgstat_stats.channel_id', 'channels.id');
        return $this->queryResult($query);
    }

    public function queryResult($query)
    {
        return request('direction') === 'asc' ? $this->orderBy($query) : $this->orderByDesc($query);
    }

    public function by_tgstat_participants_count() {

    }


    // filters

    public function title($value)
    {
        return $this->where('title', 'like', '%' . $value . '%');
    }

    public function categories($value)
    {
        return $this->whereHas('categories', function ($query) use ($value) {
            return $query->where('id', $value);
        });
    }

    public function subscribers_from($value)
    {
        return $this->whereHas('avgSubscribers', function ($query) use ($value) {
            return $query->where('total', '>=', $value);
        });
    }

    public function subscribers_to($value)
    {
        return $this->whereHas('avgSubscribers', function ($query) use ($value) {
            return $query->where('total', '<=', $value);
        });
    }

    public function avg_post_view_from($value)
    {
        return $this->whereHas('avgPostView', function ($query) use ($value) {
            return $query->where('total', '>=', $value);
        });
    }

    public function avg_post_view_to($value)
    {
        return $this->whereHas('avgPostView', function ($query) use ($value) {
            return $query->where('total', '<=', $value);
        });
    }

    public function prices($value)
    {
        if($value == 7) {
            return $this->where('author_post',1);
        } else {
            return $this->whereHas('prices', function ($query) use ($value) {
                return $query->where('post_price_type_id', $value);
            });
        }

    }

    public function price_from($value)
    {
        if (request('prices') !== 7)
            return $this->whereHas('prices', function ($query) use ($value) {
                return $query->where('price', '>=', $value)->where('post_price_type_id', request('prices'));
            });
    }

    public function price_to($value)
    {
        if (request('prices') !== 7)
            return $this->whereHas('prices', function ($query) use ($value) {
                return $query->where('price', '<=', $value)->where('post_price_type_id', request('prices'));
            });
    }

    public function owner_id($value) {
        return $this->where('owner_id',$value);
    }

    public function not_owner_id($value) {
        return $this->where('owner_id','!=',$value);
    }

/*    public function silence($value) {

    }*/


}
