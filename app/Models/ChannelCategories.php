<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Eloquent;

/**
 * Class ChannelCategories
 *
 * @package App\Models
 * @property integer $channel_id
 * @property integer $category_id
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategories whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelCategories whereChannelId($value)
 */
class ChannelCategories extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'category_channel';
    protected $primaryKey = ['channel_id', 'category_id'];
    protected $fillable = ['channel_id', 'category_id'];
    public $timestamps = false;
}
