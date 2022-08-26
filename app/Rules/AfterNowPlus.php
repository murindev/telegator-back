<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class AfterNowPlus implements Rule
{
    private $interval;

    /**
     * Create a new rule instance.
     *
     * @param $interval
     */
    public function __construct($interval)
    {
        $this->interval = $interval;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new Carbon($value))->timestamp - Carbon::now()->timestamp >= $this->interval;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute must be datetime string and be after now plus {$this->interval} seconds.";
    }
}
