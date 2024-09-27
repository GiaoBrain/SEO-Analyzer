<?php

namespace App\Http\Requests;

use App\Rules\ValidateKeywordsCountRule;
use Illuminate\Foundation\Http\FormRequest;

class ProcessKeywordResearchRequest extends FormRequest
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
            'keywords' => ['required', 'string', 'min:1', 'max:2048', new ValidateKeywordsCountRule()],
            'country' => ['nullable', 'string'],
            'currency' => ['nullable', 'string'],
            'g-recaptcha-response' => [(config('settings.captcha_keyword_research') ? 'required' : 'sometimes'), 'captcha']
        ];
    }
}
