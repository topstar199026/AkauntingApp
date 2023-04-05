<?php

namespace Modules\Leaves\Http\Requests;

use App\Abstracts\Http\FormRequest;

class LeaveType extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }
}
