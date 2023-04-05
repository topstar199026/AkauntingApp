<?php

namespace Modules\Leaves\Http\Requests;

use App\Abstracts\Http\FormRequest;
use Illuminate\Support\Str;

class Entitlement extends FormRequest
{
    public function rules(): array
    {
        return [
            'policy_id' => 'required',
            'employees' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            'policy_id.required' => trans('validation.required', ['attribute' => Str::lower(trans('leaves::general.leave_policy'))]),
            'employees.required' => trans('validation.required', ['attribute' => Str::lower(trans_choice('employees::general.employees', 2))]),
        ];
    }
}
