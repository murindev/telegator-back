<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as DefaultModel;
use phpDocumentor\Reflection\Types\Static_;

/**
 * Class Model
 *
 * @package App\Models
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model query()
 */
class Model extends DefaultModel
{
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::RFC3339_EXTENDED);
    }

    public function fillFillable(array $data): self
    {
        $this->fill($this->fillableFromArray($data));

        return $this;
    }
}
