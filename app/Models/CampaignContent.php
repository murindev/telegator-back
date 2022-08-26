<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CampaignContent
 *
 * @package App\Models
 * @property integer $campaign_id
 * @property string  $message
 * @property string  $message_raw
 * @property boolean $with_video
 * @property boolean $with_image
 * @property string  $link
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read Campaign $campaign
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent whereMessageRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent whereWithImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignContent whereWithVideo($value)
 */
class CampaignContent extends Model
{
    use HasFactory;

    public    $incrementing = false;
    protected $primaryKey   = 'campaign_id';

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function notEmpty(): bool
    {
        return $this->exists && $this->message;
    }
}
