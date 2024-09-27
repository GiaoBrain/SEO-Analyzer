<?php

namespace App\Http\Requests;

use App\Rules\ValidateReportPasswordRule;
use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;

class ValidateReportPasswordRequest extends FormRequest
{
    /**
     * @var
     */
    var $report;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->report = Report::where('id', $this->route('id'))->firstOrFail();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => ['required', new ValidateReportPasswordRule($this->report)]
        ];
    }
}
