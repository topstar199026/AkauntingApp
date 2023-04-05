<?php

namespace Modules\Receipt\Http\Requests;

use App\Abstracts\Http\FormRequest;

class Import extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $import = 'required';

        if ($this->files->get('attachment', null)) {
            $import = 'mimes:' . config('filesystems.mimes') . '|between:0,' . config('filesystems.max_size') * 1024;
        }

        return [
            'attachment' => $import
        ];
    }
}
