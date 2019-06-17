<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckAgeclass implements Rule
{
    protected $ageclasses;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct( )
    {

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
        return true; #!array_diff($value, $this->ageclasses);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
