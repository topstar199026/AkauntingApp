<?php

namespace Modules\Leaves\Http\Requests;

use App\Abstracts\Http\FormRequest;

class Year extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'       => 'required|string',
            'start_date' => 'required|date_format:Y-m-d|before_or_equal:end_date',
            'end_date'   => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }
}
