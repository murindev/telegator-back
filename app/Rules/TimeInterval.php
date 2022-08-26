<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class TimeInterval implements Rule
{
    private $startAttr;
    private $endAttr;
    private $interval;

    /**
     * Create a new rule instance.
     *
     * @param        $interval
     * @param string $startAttr
     * @param string $endAttr
     */
    public function __construct($interval, $startAttr = 'start_dts', $endAttr = 'end_dts')
    {
        $this->interval  = $interval;
        $this->startAttr = $startAttr;
        $this->endAttr   = $endAttr;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!key_exists($this->startAttr, $value) || !key_exists($this->endAttr, $value)) return false;

        $start = new Carbon($value[$this->startAttr]);
        $end   = new Carbon($value[$this->endAttr]);

        return $end->timestamp - $start->timestamp >= $this->interval;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Time range is too short. It must be greater than {$this->interval} seconds";
    }
}
