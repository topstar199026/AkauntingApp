<?php

namespace Modules\Leaves\Http\Requests\Modals;

use App\Abstracts\Http\FormRequest;
use Illuminate\Support\Carbon;
use Modules\Employees\Models\Employee;
use Modules\Leaves\Models\Entitlement;

class Leave extends FormRequest
{
    public function rules(): array
    {
        $entitlement = Entitlement::findOrFail($this['entitlement_id']);

        $employee = Employee::findOrFail($this['employee_id']);

        $min_start_date = Carbon::parse($employee->hired_at)->addDays($entitlement->policy->applicable_after);

        return [
            'entitlement_id' => 'required',
            'employee_id'    => 'required',
            'start_date'     => [
                'required',
                'date_format:Y-m-d',
                'before_or_equal:end_date',
                'after_or_equal:' . $min_start_date->format(company_date_format()),
            ],
            'end_date'       => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        if ($this['from_calendar']) {
            $this->merge([
                'employee_id' => Entitlement::findOrFail($this['entitlement_id'])->employee_id,
            ]);
        }
    }
}
