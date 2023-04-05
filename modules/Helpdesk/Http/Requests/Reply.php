<?php

namespace Modules\Helpdesk\Http\Requests;

use App\Abstracts\Http\FormRequest;
use Illuminate\Support\Str;

class Reply extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'integer',
            'ticket_id' => 'integer',
            'message' => 'required|string',
            'internal' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'message.required' => trans('validation.required', ['attribute' => Str::lower(trans('helpdesk::general.reply.new_reply'))]),
        ];
    }
}
