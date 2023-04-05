<?php

namespace Modules\Helpdesk\Http\Requests;

use App\Abstracts\Http\FormRequest;
use Illuminate\Support\Str;

class Ticket extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $attachment = 'nullable';

        if ($this->files->get('attachment')) {
            $attachment = 'mimes:' . config('filesystems.mimes') . '|between:0,' . config('filesystems.max_size') * 1024;
        }

        return [
            'id' => 'integer',
            'subject' => 'required|string',
            'message' => 'required|string',
            'category_id' => 'required',
            'created_by' => 'integer',
            'document_ids' => 'nullable|array',
            'attachment.*' => $attachment,
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => trans('validation.required', ['attribute' => Str::lower(trans('helpdesk::general.ticket.subject'))]),
            'message.required' => trans('validation.required', ['attribute' => Str::lower(trans('helpdesk::general.ticket.message'))]),
            'category_id.required' => trans('validation.required', ['attribute' => Str::lower(trans('helpdesk::general.ticket.category'))]),
        ];
    }
}
