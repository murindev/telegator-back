<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExistArrayIdSelected implements Rule
{
    private $model;

    public function __construct(string $model)
    {
        $this->model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_array($value)) {
            return false;
        }

        if (empty($value)) {
            return false;
        }

        foreach ($value as $id) {
            if (!is_int($id)) {
                return false;
            }
        }
        $model = new $this->model();
        $queriedModels = $model::whereIn('id', $value)->get();

        return count($queriedModels) === count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please, select right categories';
    }
}
