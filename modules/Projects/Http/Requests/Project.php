<?php

namespace Modules\Projects\Http\Requests;

use App\Abstracts\Http\FormRequest as Request;

class Project extends Request
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
        $attachment = 'nullable';

        if ($this->files->get('attachment')) {
            $attachment = 'mimes:' . config('filesystems.mimes') . ',pdf,txt,doc,docs,xls,xlsx,cvs,zip|between:0,' . config('filesystems.max_size') * 1024;
        }

        return [
            'name'              => 'required|string|unique:projects',
            'customer_id'       => 'required|integer',
            'started_at'        => 'required|date',
            'ended_at'          => 'nullable|date',
            'members'           => 'required|array',
            'billing_type'      => 'required|string',
            'total_rate'        => 'required_if:billing_type,fixed-rate|amount:0',
            'rate_per_hour'     => 'required_if:billing_type,projects-hours|amount:0',
            'attachment.*'      => $attachment,
        ];
    }
}
