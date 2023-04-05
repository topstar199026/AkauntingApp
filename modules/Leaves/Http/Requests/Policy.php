<?php

namespace Modules\Leaves\Http\Requests;

use App\Abstracts\Http\FormRequest;
use Illuminate\Support\Str;

class Policy extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'             => 'required|string',
            'leave_type_id'    => 'required',
            'year_id'          => 'required',
            'days'             => 'required|integer|min:1',
            'applicable_after' => 'required|integer',
            'carryover_days'   => 'required|integer',
            'is_paid'          => 'required|integer|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'leave_type_id.required' => trans('validation.required', ['attribute' => Str::lower(trans_choice('leaves::general.leave_types', 1))]),
            'year_id.required'       => trans('validation.required', ['attribute' => Str::lower(trans('leaves::general.leave_year'))]),
        ];
    }
}
