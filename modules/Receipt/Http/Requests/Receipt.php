<?php

namespace Modules\Receipt\Http\Requests;

use App\Abstracts\Http\FormRequest;

class Receipt extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required',
            'merchant' => 'required|string',
            'total_amount' => 'required|amount',
            'tax_amount' => 'nullable',
            'category_id' => 'required|integer',
            'payment_method' => 'required|string',
            'payment_id' => 'nullable',
        ];
    }
}
