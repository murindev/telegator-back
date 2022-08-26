<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

/**
 * App\Models\Post\PostPrice
 *
 * @property int $id
 * @property int $channel_id
 * @property int $post_price_type_id
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Post\PostPriceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostPrice whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPrice wherePostPriceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PostPrice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function addPrices(Request $request, $channel_id){
        $priceTypes = PostPriceType::pluck('name','id');

        foreach ($request->all() as $key => $value){
            foreach ($priceTypes as $id => $name){
                if($name == $key){
                    PostPrice::updateOrCreate([
                        'channel_id' => $channel_id,
                        'post_price_type_id' => $id
                    ], ['price' => $value]);
//                    $this->channel_id = $channel_id;
//                    $this->post_price_type_id = $id;
//                    $this->price = ;
//                    $this->save();
                }
            }
        }

    }
}
