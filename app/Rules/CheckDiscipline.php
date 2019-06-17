<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckDiscipline implements Rule
{
    protected $disciplines;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($disciplines)
    {
        $this->disciplines = $disciplines;
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
        return !array_diff($value, $this->disciplines);
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
