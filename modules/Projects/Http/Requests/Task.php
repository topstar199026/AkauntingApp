<?php

namespace Modules\Projects\Http\Requests;

use App\Abstracts\Http\FormRequest as Request;
use Modules\Projects\Models\Project;

class Task extends Request
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

        $rules = [
            'name'          => 'required|string',
            'started_at'    => 'required|date',
            'ended_at'      => 'nullable|date|after_or_equal:started_at',
            'attachment.*'  => $attachment,
        ];

        $project = Project::find($this->request->get('project_id'));

        if ($project->billing_type === 'task-hours') {
            $rules['hourly_rate'] = 'required|amount';
        }

        return $rules;
    }
}
