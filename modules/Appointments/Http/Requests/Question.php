<?php

namespace Modules\Appointments\Http\Requests;

use App\Abstracts\Http\FormRequest as Request;

class Question extends Request
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
            'question'          => 'required|string',
            'question_type'     => 'required|integer',
            'required_answer'   => 'integer|boolean',
            'enabled'           => 'integer|boolean',
        ];
    }
}
