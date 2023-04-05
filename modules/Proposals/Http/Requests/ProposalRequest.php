<?php

namespace Modules\Proposals\Http\Requests;

use App\Abstracts\Http\FormRequest;

class ProposalRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (module('crm') && request('create_deal') == 'true') {
            return [
                'content_html' => 'required',
                'crm_contact_id' => 'required',
                'crm_company_id' => 'required',
                'name' => 'required',
                'amount' => 'required',
                'owner_id' => 'required',
                'pipeline_id' => 'required',
                'color' => 'required',
                'closed_at' => 'required',
            ];
        }

        return [
            'content_html' => 'required',
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
