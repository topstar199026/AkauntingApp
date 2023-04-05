<x-form
    id="register_leave_form"
    route="leaves.modals.leaves.register"
    :model="!empty($entitlement) ? $entitlement : false">
    <x-form.section>
        <x-slot name="body">
            @if(isset($entitlement))
                <x-form.input.hidden
                    name="entitlement_id"
                    :value="$entitlement->id"
                    id="entitlement_id"
                />

                <x-form.input.hidden
                    name="employee_id"
                    :value="$entitlement->employee->id"
                    id="employee_id"
                />
            @else
                <x-form.group.select
                    name="entitlement_id"
                    :label="trans_choice('leaves::general.entitlements', 1)"
                    :options="$entitlements"
                />

                <x-form.input.hidden
                    name="from_calendar"
                    value="1"
                />
            @endif

            <x-form.group.date
                name="start_date"
                label="{{ trans('general.start_date') }}"
                value="{{ Date::now()->toDateString() }}" 
                show-date-format="{{ company_date_format() }}"
                date-format="Y-m-d"
            />

            <x-form.group.date
                name="end_date"
                label="{{ trans('general.end_date') }}"
                value="{{ Date::now()->toDateString() }}" 
                show-date-format="{{ company_date_format() }}"
                date-format="Y-m-d"
            />
        </x-slot>
    </x-form.section>
</x-form>
