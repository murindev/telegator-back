<?php

namespace App\Models\Post;

use App\Filters\PostQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Post\Post
 *
 * @property int $id
 * @property int $channel_id
 * @property string|null $title Название
 * @property string|null $content Содержание
 * @property int|null $views_cnt Кол-во просмотров
 * @property int|null $forwards_cnt Количество forward
 * @property int|null $is_advert Количество forward
 * @property int|null $engagement_rate Engagement Rate, %
 * @property int|null $comments_cnt Комментарии
 * @property int|null $reactions_cnt Количество нестандартных реакций
 * @property int|null $duration Продолжительность публикации
 * @property int|null $purity_duration Продолжительность “чистоты” ленты после публикации рекламного поста
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Post\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCommentsCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereEngagementRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereForwardsCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsAdvert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePurityDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereReactionsCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereViewsCnt($value)
 * @mixin \Eloquent
 * @method static PostQueryBuilder|Post byId()
 * @method static PostQueryBuilder|Post byTitle()
 * @method static PostQueryBuilder|Post filter()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post\PostMedia[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post\PostView[] $postViews
 * @property-read int|null $post_views_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post\PostView[] $postViewsLast
 * @property-read int|null $post_views_last_count
 * @method static PostQueryBuilder|Post byCreatedAt()
 * @method static PostQueryBuilder|Post byForwardsCnt()
 * @method static PostQueryBuilder|Post byIsAdvert()
 * @method static PostQueryBuilder|Post byViewsCnt()
 */
class Post extends Model
{
    use HasFactory;


    protected $relations = ['media', 'postViewsLast'];

    // relations
    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class);
    }

    // @TODO-uretral:  -> relation - > delete candidate
    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    public function postViewsLast(): HasMany
    {
        return $this->hasMany(PostView::class)->whereRaw('date(tg_stat_created_at) = (select date(max(tg_stat_created_at)))');
    }

    // controller ent
    public function newEloquentBuilder($query): PostQueryBuilder
    {
        return new PostQueryBuilder($query);
    }

    public function channelPosts()
    {
        return $this->whereChannelId(request('channelId'))->with($this->relations)->filter()->get();
    }

    public function post()
    {
        return $this->with($this->relations)->whereId(request('id'))->first();
    }

    public function postWithViews()
    {
        return $this->with($this->relations)->whereId(request('id'))->first();
    }
}
