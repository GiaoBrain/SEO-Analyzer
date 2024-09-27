<?php

namespace App\Http\Requests;

use App\Rules\ValidateCountryKeyRule;
use App\Rules\ValidateDomainNameRule;
use Illuminate\Foundation\Http\FormRequest;

class ProcessIndexedPagesCheckerRequest extends FormRequest
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
            'domain' => ['nullable', 'string', 'max:2048', new ValidateDomainNameRule()],
            'country' => ['required', new ValidateCountryKeyRule(['AX', 'BQ', 'CT', 'NQ', 'FQ', 'GG', 'IM', 'JE', 'JT', 'FX', 'MI', 'ME', 'NT', 'VD', 'PC', 'PZ', 'YD', 'BL', 'MF', 'RS', 'PU', 'SU', 'ZZ', 'WK'])],
            'g-recaptcha-response' => [(config('settings.captcha_indexed_pages_checker') ? 'required' : 'sometimes'), 'captcha']
        ];
    }
}
