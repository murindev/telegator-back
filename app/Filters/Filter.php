<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter extends Builder
{
    /**
     * @return Builder
     */
    public function filter(): Builder
    {


        foreach (request()->all() as $name => $value) {

            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }

            if (request('orderBy')) {
                call_user_func_array([$this, request('orderBy')], array_filter([request('direction')]));
            }

        }
        return $this;
    }
}

