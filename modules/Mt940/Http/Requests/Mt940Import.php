<?php

namespace Modules\Mt940\Http\Requests;

use App\Abstracts\Http\FormRequest;

class Mt940Import extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $import = 'required';

        if ($this->files->get('import', null)) {
            $import = 'mimes:txt,300,940,sta,mt940|between:0,' . config('filesystems.max_size') * 1024;
        }

        return [
            'import' => $import
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
