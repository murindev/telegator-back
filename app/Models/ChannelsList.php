<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ChannelsList
 * 
 * private entity uses to add channels
 *
 * @package App\Models
 * @property integer $id
 * @property string  $name
 * @property string  $slug         // calc
 * @property string  $tg_link
 * @property boolean $is_public
 * @property string  $contact
 * @property string  $contact2
 * @property string  $subjects
 * @property string  $subscribers_count
 * @property string  $reach_avg
 * @property string  $post_price
 * @property string  $post_price_additional
 * @property integer $created_at
 * @property integer $updated_at
 * @property ChannelData $data
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereContact2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList wherePostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList wherePostPriceAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereReachAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereSubjects($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereSubscribersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereTgLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelsList whereUpdatedAt($value)
 */
class ChannelsList extends Model
{
    use HasFactory;

    protected $table = 'channels_list';

    protected $fillable = [
        'name',
        'slug',
        'contact',
        'contact2',
        'subjects',
        'tg_link',
        'is_public',
        'subscribers_count',
        'reach_avg',
        'post_price',
        'post_price_additional',
    ];
}
