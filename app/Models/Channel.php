<?php

namespace App\Models;

use App\Exceptions\TgChannelNotFoundException;
use App\Filters\ChannelQueryBuilder;
use App\Models\Post\PostPrice;
use App\Models\Statistics\AvgAdvertView;
use App\Models\Statistics\AvgCiting;
use App\Models\Statistics\AvgDailySubscription;
use App\Models\Statistics\AvgPostView;
use App\Models\Statistics\AvgSex;
use App\Models\Statistics\AvgSubscriber;
use App\Models\Statistics\AvgPostCount;
use App\Models\Task\TaskChannel;
use App\Models\Tgstat\TgstatAvgPostsReach;
use App\Models\Tgstat\TgstatCommonInfo;
use App\Models\Tgstat\TgstatForward;
use App\Models\Tgstat\TgstatMention;
use App\Models\Tgstat\TgstatPost;
use App\Models\Tgstat\TgstatPostsStat;
use App\Models\Tgstat\TgstatPostsToViewsByHour;
use App\Models\Tgstat\TgstatStat;
use App\Models\Tgstat\TgstatSubscriber;
use App\Models\Tgstat\TgstatView;
use App\Services\TgStat\Models\TgStatChannel;
use App\Services\Tme\TmeParser;
use App\Utils\Helper;
use Carbon\Carbon;
use danog\MadelineProto\auth;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class Channel
 *
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $tg_link
 * @property boolean $is_public
 * @property boolean $is_deleted
 * @property integer $owner_id
 * @property string $contact
 * @property string $subjects
 * @property float $price
 * @property string $avatar
 * @property string $description
 * @property integer $parsed_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read integer $members_count
 * @property-read integer $reach_avg
 * @property-read float $er
 * @property-read float $cpu
 * @property-read float $index
 * @property-read ChannelData $data
 * @property-read TgStatChannel $tg_stat_channel
 * @property-read Category[] $categories
 * @mixin Eloquent
 * @property string $contact_tg
 * @property int $status
 * @property-read int|null $categories_count
 * @property-read \App\Models\ChannelStat|null $channelStats
 * @property-read array $categories_ids
 * @property-read array $categories_labels
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubcribersCount[] $subscribersCount
 * @property-read int|null $subscribers_count_count
 * @method static \Illuminate\Database\Eloquent\Builder|Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereContactTg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereParsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereTgLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Channel whereUpdatedAt($value)
 * @property-read AvgAdvertView|null $avgAdvertViews
 * @property-read AvgCiting|null $avgCiting
 * @property-read AvgDailySubscription|null $avgDailySubscription
 * @property-read AvgPostView|null $avgPostView
 * @property-read AvgSex|null $avgSex
 * @property-read AvgSubscriber|null $avgSubscribers
 * @property-read AvgPostCount|null $postCount
 * @property-read \Illuminate\Database\Eloquent\Collection|PostPrice[] $prices
 * @property-read int|null $prices_count
 * @method static ChannelQueryBuilder|Channel byCategories()
 * @method static ChannelQueryBuilder|Channel byId()
 * @method static ChannelQueryBuilder|Channel byPostViewEr()
 * @method static ChannelQueryBuilder|Channel byPostViewTotal()
 * @method static ChannelQueryBuilder|Channel byPrice()
 * @method static ChannelQueryBuilder|Channel bySubscribers()
 * @method static ChannelQueryBuilder|Channel byTitle()
 * @method static ChannelQueryBuilder|Channel filter()
 * @method static ChannelQueryBuilder|Channel queryResult($query)
 * @property-read AvgPostCount|null $avgPostCount
 * @method static ChannelQueryBuilder|Channel avg_post_view_from($value)
 * @method static ChannelQueryBuilder|Channel avg_post_view_to($value)
// * // * // * @method static ChannelQueryBuilder|Channel categories($value)
 * @method static ChannelQueryBuilder|Channel subscribers_from($value)
 * @method static ChannelQueryBuilder|Channel subscribers_to($value)
 * @method static ChannelQueryBuilder|Channel title($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|TgstatAvgPostsReach[] $tgstat_avg_posts_reach
 * @property-read int|null $tgstat_avg_posts_reach_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TgstatPostsToViewsByHour[] $tgstat_channel_views_hours
 * @property-read int|null $tgstat_channel_views_hours_count
 * @property-read TgstatCommonInfo|null $tgstat_common_info
 * @property-read \Illuminate\Database\Eloquent\Collection|TgstatForward[] $tgstat_forwards
 * @property-read int|null $tgstat_forwards_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TgstatMention[] $tgstat_mentions
 * @property-read int|null $tgstat_mentions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TgstatPost[] $tgstat_posts
 * @property-read int|null $tgstat_posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TgstatPostsStat[] $tgstat_posts_stats
 * @property-read int|null $tgstat_posts_stats_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TgstatPostsToViewsByHour[] $tgstat_posts_views_hours
 * @property-read int|null $tgstat_posts_views_hours_count
 * @property-read TgstatStat|null $tgstat_stat
 * @property-read \Illuminate\Database\Eloquent\Collection|TgstatSubscriber[] $tgstat_subscribers
 * @property-read int|null $tgstat_subscribers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TgstatView[] $tgstat_views
 * @property-read int|null $tgstat_views_count
// * @method static ChannelQueryBuilder|Channel categories($value)
// * @method static ChannelQueryBuilder|Channel prices($value)
 */
class Channel extends Model
{
    use HasFactory;

    const STATUS_NOT_PARSED = 0;
    const STATUS_PARSED = 1;

    const IS_PUBLIC = 1;
    const IS_NOT_PUBLIC = 0;

    const REPEAT_TRANSACTIONS = 3;

    const CHANNELS_PER_PAGE = 10;

    protected $fillable = [
        'title',
        'slug',
        'contact',
        'subjects',
        'tg_link',
        'is_public'
    ];

    protected $casts = [
        'parsed_at' => 'datetime'
    ];

    protected $hidden = [
        'tg_stat_channel',
        'data',
        'members_count',
        'reach_avg',
//        'er',
        'cpu',
        'index',
        'categories_labels'
    ];

    protected $appends = [
        'members_count',
        'reach_avg',
        'cpu',
        'index',
        'categories_labels'
    ];
    protected $relations = [
        'actualSubscribersCount',
        'categories',
//        'avgAdvertViews',
//        'avgSubscribers',
//        'avgDailySubscription',
//        'avgCiting',
//        'avgPostView',
//        'avgPostCount',
//        'avgSex',
        ////////
        'tgstat_common_info',
        'tgstat_stat',
        'tgstat_subscribers_last',




        'prices'

/*
tgstat_common_info
tgstat_stat
tgstat_posts
tgstat_avg_posts_reach
tgstat_forwards
tgstat_mentions
tgstat_posts_stats
tgstat_channel_views_hours
tgstat_subscribers
tgstat_views*/
    ];

    protected array $relations_channel = [
        'tgstat_posts', 'tgstat_posts_views_hours', 'avg_posts_views','avg_post_by_hour_last_week','avg_post_by_hour_this_week'
    ];


    public function getCategoriesIdsAttribute(): array
    {
        return $this->channelCategories()->get()->map(function ($item) {
            return $item['category_id'];
        })->toArray();
    }

    public function getCategoriesLabelsAttribute(): array
    {
        return $this->categories->map(function (Category $item) {
            return $item->label;
        })->toArray();
    }

    protected function channelCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ChannelCategories::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function parsedNow()
    {
        $this->parsed_at = $this->freshTimestamp();
        $this->save();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function data()
    {
        return $this->hasOne(ChannelData::class);
    }

    public function channelStats()
    {
        return $this->hasOne(ChannelStat::class);
    }

    public function subscribersCount()
    {
        return $this->hasMany(SubcribersCount::class);
    }

    public function actualSubscribersCount()
    {
        return $this->subscribersCount()->latest()->limit(1);
    }

    public function tg_stat_channel()
    {
        return $this->hasOne(TgStatChannel::class)->withDefault();
    }

    public function getMembersCountAttribute()
    {
        return $this->tg_stat_channel->members;
    }


    public function getReachAvgAttribute()
    {
        return $this->tg_stat_channel->avg_post_reach;
    }

    public function getIndexAttribute()
    {
        return $this->tg_stat_channel->citation_index;
    }

    public function getCpuAttribute()
    {
        return $this->reach_avg ? $this->price / $this->reach_avg : null;
    }

    /**
     * @throws TgChannelNotFoundException
     * @throws \Throwable
     */
    public function addChannel($request)
    {

        $arLink = explode('/', $request->tg_link);

        $tg_parse_data = TmeParser::fetchChannelInfo(array_pop($arLink));

        if($tg_parse_data->title) {
            DB::transaction(function () use ($request, $tg_parse_data) {
                $this->tg_link = $request->tg_link;
                $this->price = $request->price;
                $this->contact_tg = $request->contact_tg;
                $this->contact = $request->contact;
                $this->status = self::STATUS_NOT_PARSED;
                $this->is_public = self::IS_PUBLIC;

                $this->owner_id = \auth()->id();

                $this->title = $tg_parse_data->title;
                $this->description = $tg_parse_data->description;
                $this->avatar = $this->saveAvatar($request->tg_link);
                $this->author_post = $request->author_post;


                $this->save();

                foreach ($request->categories as $category_id) {
                    ChannelCategories::create(['channel_id' => $this->id, 'category_id' => $category_id]);
                }

                foreach ($request->prices as $price) {
                    PostPrice::updateOrCreate(
                        ['channel_id' => $this->id, 'post_price_type_id' => $price['post_price_type_id']],
                        ['price' => $price['price']]
                    );
                }
            }, self::REPEAT_TRANSACTIONS);
        } else {
            throw new \Exception('Такого канала не существует', 404);
        }
    }

    public function saveAvatar($tg_link)
    {
        try {
            $r = explode('/', $tg_link);
            $name = array_pop($r);
            $rp = TmeParser::fetchChannelInfo($name);
            $path = Helper::storePublicFile($rp->image, 'avatars/channels/' . Str::random(6) . '/' . Str::random(6));
            if ($path) {
                return $path;
            } else {
                return '';
            }
        } catch (\Exception $e) {
            return '';
        } finally {
            return '';
        }

    }


    /////////////////////////////// new


    /**
     * Средний рекламный охват 1 публикации
     * @return HasOne
     */
    public function avgAdvertViews(): HasOne
    {
        return $this->hasOne(AvgAdvertView::class);
    }

    /**
     * Вовлеченность подписчиков (ERR)
     * @return HasOne
     */
    public function avgSubscribers(): HasOne
    {
        return $this->hasOne(AvgSubscriber::class);
    }

    /**
     * Подписки/отписки за 24 часа
     * @return HasOne
     */
    public function avgDailySubscription(): HasOne
    {
        return $this->hasOne(AvgDailySubscription::class);
    }

    /**
     * Индекс цитирования
     * @return HasOne
     */
    public function avgCiting(): HasOne
    {
        return $this->hasOne(AvgCiting::class);
    }

    /**
     * Средний охват 1 публикации
     * @return HasOne
     */
    public function avgPostView(): HasOne
    {
        return $this->hasOne(AvgPostView::class);
    }

    /**
     * Публикации
     * @return HasOne
     */
    public function avgPostCount(): HasOne
    {
        return $this->hasOne(AvgPostCount::class);
    }

    /**
     * Пол подписчиков
     * @return HasOne
     */
    public function avgSex(): HasOne
    {
        return $this->hasOne(AvgSex::class);
    }


    public function prices(): HasMany
    {
        return $this->hasMany(PostPrice::class);
    }

    // new scheme tgstat

    /** Получение информации о канале */
    public function tgstat_common_info(): HasOne
    {
        return $this->hasOne(TgstatCommonInfo::class);
    }

    /** Получение статистики канала */
    public function tgstat_stat(): HasOne
    {
        return $this->hasOne(TgstatStat::class);
    }

    /** Получение списка публикаций */
    public function tgstat_posts(): HasMany
    {
        return $this->hasMany(TgstatPost::class);
    }

    /** Получение списка публикаций */
    public function tgstat_posts_stats(): HasMany
    {
        return $this->hasMany(TgstatPostsStat::class);
    }

    /** Получение списка упоминаний */
    public function tgstat_mentions(): HasMany
    {
        return $this->hasMany(TgstatMention::class);
    }

    /** Получение списка репостов из канала */
    public function tgstat_forwards(): HasMany
    {
        return $this->hasMany(TgstatForward::class);
    }

    /** Получение кол-ва подписчиков в динамике */
    public function tgstat_subscribers(): HasMany
    {
        return $this->hasMany(TgstatSubscriber::class);
    }


    /** Получение кол-ва подписчиков за последний день */
    public function tgstat_subscribers_last(): HasOne
    {
        return $this->hasOne(TgstatSubscriber::class);
    }

    /** Получение кол-ва просмотров в динамике */
    public function tgstat_views(): HasMany
    {
        return $this->hasMany(TgstatView::class);
    }

    /** Получение среднего охвата публикаций канала в динамике*/
    public function tgstat_avg_posts_reach(): HasMany
    {
        return $this->hasMany(TgstatAvgPostsReach::class);
    }

    public function tgstat_channel_views_hours(): HasMany
    {
        return $this->hasMany(TgstatPostsToViewsByHour::class)->where('mentionType', 'channel');
    }

    public function tgstat_posts_views_hours(): HasMany
    {
        return $this->hasMany(TgstatPostsToViewsByHour::class);
    }


    public function avg_posts_views() {
        return $this->hasOne(TgstatPostsToViewsByHour::class)->selectRaw('channel_id,AVG(tgstat_posts_to_views_by_hours.views) AS views');
    }

    public function avg_post_by_hour_this_week() {

        return $this->hasMany(TgstatPostsToViewsByHour::class)
            ->selectRaw('channel_id,AVG(tgstat_posts_to_views_by_hours.views) AS views')
            ->whereBetween('updated_at',[Carbon::now()->subDays(7)->toDateTimeString(),Carbon::now()->toDateTimeString()])
            ->groupBy('hour');
    }

    public function last_published_task() : HasOne
    {
        return $this->hasOne(TaskChannel::class)->latest();
    }


    public function avg_post_by_hour_last_week() {

        return $this->hasMany(TgstatPostsToViewsByHour::class)
            ->selectRaw('channel_id,AVG(tgstat_posts_to_views_by_hours.views) AS views')
            ->whereBetween('updated_at',[Carbon::now()->subDays(14)->toDateTimeString(),Carbon::now()->subDays(7)->toDateTimeString()])
            ->groupBy('hour');

    }

    public function newEloquentBuilder($query): ChannelQueryBuilder
    {
        return new ChannelQueryBuilder($query);
    }

    public function channel($id)
    {
        return $this->with(array_merge($this->relations,$this->relations_channel))->whereId($id)->first();
    }

    public function index()
    {
        return $this
            ->select('id', 'title', 'avatar', 'price', 'contact', 'tg_link','author_post')
            ->with( array_merge($this->relations,['last_published_task']))
            ->filter()
//            ->orderBy(request('orderBy'), request('direction'))
            ->paginate(request('rows'));
    }

    public function byOwner()
    {
        return $this
            ->select('id', 'title', 'avatar', 'price', 'contact', 'tg_link','author_post')
            ->with( array_merge($this->relations,['last_published_task']))
            ->where('owner_id', \auth()->id())
            ->filter()
//            ->orderBy(request('orderBy'), request('direction'))
            ->paginate(request('rows'));
    }
}
