<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Campaign\CampaignChannel
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $channel_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Campaign\CampaignChannelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignChannel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignChannel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignChannel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignChannel whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignChannel whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignChannel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignChannel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignChannel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CampaignChannel extends Model
{
    use HasFactory;
}
