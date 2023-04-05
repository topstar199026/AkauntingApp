<?php

namespace Modules\Projects\Http\Requests;

use App\Abstracts\Http\FormRequest as Request;

class Milestone extends Request
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
            'name' => 'required|string',
            'deadline_at' => 'required|date',
        ];
    }
}
