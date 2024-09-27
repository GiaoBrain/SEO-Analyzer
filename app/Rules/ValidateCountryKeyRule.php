<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateCountryKeyRule implements Rule
{
    /**
     * The list of country codes to be excluded.
     *
     * @var
     */
    var $excludedCountries;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($excludedCountries = null)
    {
        $this->excludedCountries = array_flip($excludedCountries);
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
        if (array_key_exists($value, array_diff_key(config('countries'), $this->excludedCountries))) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Invalid country.');
    }
}
