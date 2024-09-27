<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPreferencesRequest extends FormRequest
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
            'brand_logo' => ['nullable', 'url', 'max:2048'],
            'brand_name' => ['nullable', 'string', 'max:128'],
            'brand_url' => ['nullable', 'url', 'max:2048'],
            'brand_email' => ['nullable', 'string', 'email', 'max:255'],
            'brand_phone' => ['nullable', 'string', 'max:64'],
            'default_privacy' => ['required', 'integer', 'between:0,1']
        ];
    }
}
