<?php

namespace App\Http\Requests;

use App\Rules\ReportLimitGateRule;
use App\Rules\ValidateBadWordsRule;
use App\Rules\ValidateReportUrlRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'url' => ['bail', 'required', 'max:2048', 'url', new ValidateBadWordsRule(), new ReportLimitGateRule($this->user()), new ValidateReportUrlRule($this)],
            'sitemap' => ['nullable', 'integer', 'between:0,1'],
            'privacy' => ['nullable', 'integer', 'between:0,2'],
            'password' => [Rule::requiredIf($this->input('privacy') == 2), 'nullable', 'string', 'min:1', 'max:128'],
        ];
    }
}
