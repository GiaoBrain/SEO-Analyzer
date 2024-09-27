<?php

namespace App\Http\Requests;

use App\Models\Report;
use App\Rules\ValidateReportUrlRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateReportRequest extends FormRequest
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
        if (Auth::check()) {
            $this->report = Report::where('id', '=', $this->route('id'))->first();

            // If the report exists
            if ($this->report) {
                // If the user is an admin
                if ($this->has('user_id') && $this->user()->role == 1) {
                    return true;
                }

                // If the user is the owner of the report
                if ($this->report->user_id == $this->user()->id) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'results' => ['bail', 'sometimes', ($this->input('results') ? new ValidateReportUrlRule($this, $this->report) : null)],
            'privacy' => ['sometimes', 'required', 'integer', 'between:0,2'],
            'password' => [(in_array($this->input('privacy'), [0, 1]) ? 'nullable' : 'sometimes'), 'string', 'min:1', 'max:128'],
        ];
    }
}
