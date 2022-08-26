<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Post\PostPriceType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Post\PostPriceTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPriceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostPriceType newQuery()
 * @method static \Illuminate\Database\Query\Builder|PostPriceType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PostPriceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostPriceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPriceType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPriceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPriceType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostPriceType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PostPriceType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PostPriceType withoutTrashed()
 * @mixin \Eloquent
 */
class PostPriceType extends Model
{
    use HasFactory;

    public function getTypeId($name){
        return $this->where('name', $name)->first()->getAttribute('id');
    }

}
