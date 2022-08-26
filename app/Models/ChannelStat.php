<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChannelStat
 *
 * @property int $channel_id
 * @property int $publication_count
 * @property int $avg_publication_count
 * @property int $avg_time_publication
 * @property int $avg_view_publication
 * @property int $avg_share_publication
 * @property int $avg_coverage
 * @property int $avg_iterations
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat whereAvgCoverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat whereAvgIterations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat whereAvgPublicationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat whereAvgSharePublication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat whereAvgTimePublication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat whereAvgViewPublication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat wherePublicationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelStat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChannelStat extends Model
{
    use HasFactory;
}
