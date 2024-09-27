<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateReportPasswordRule implements Rule
{
    /**
     * @var
     */
    private $report;

    /**
     * Create a new rule instance.
     *
     * @param $report
     * @return void
     */
    public function __construct($report)
    {
        $this->report = $report;
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
        if ($this->report->password == $value) {
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
        return __('The entered password is not correct.');
    }
}
