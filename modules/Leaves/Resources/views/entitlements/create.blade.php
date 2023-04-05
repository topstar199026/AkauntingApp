<x-layouts.admin>
    <x-slot name="title">
        {{ trans('leaves::entitlements.assign_leave_policy') }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form
                id="entitlement"
                route="leaves.entitlements.store">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head
                            :title="trans('general.general')"
                            description="{!! trans('leaves::entitlements.use_filters') !!}"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.select
                            name="leave_type_id"
                            :label="trans_choice('leaves::general.leave_types', 1)"
                            :options="$leave_types"
                            change="applyFilters"
                        />

                        <x-form.group.select
                            name="year_id"
                            :label="trans('leaves::general.leave_year')"
                            :options="$leave_years"
                            change="applyFilters"
                        />

                        <x-form.group.select
                            name="department_id"
                            :label="trans_choice('employees::general.departments', 1)"
                            :options="$departments"
                            change="applyFilters"
                        />

                        <x-form.group.select
                            name="gender"
                            :label="trans('employees::employees.gender')"
                            :options="$genders"
                            change="applyFilters"
                        />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head
                            :title="trans('leaves::entitlements.assignment')"
                            description=""
                        />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.select
                            name="policy_id"
                            :label="trans('leaves::general.leave_policy')"
                            :options="$leave_policies"
                            dynamic-options="policies"
                        />

                        <x-form.group.select
                            name="employees"
                            :label="trans_choice('employees::general.employees', 2)"
                            :options="$employees"
                            :selected="! empty(request()->employee_id) ? [request()->employee_id] : []"
                            dynamic-options="employees"
                            multiple
                        />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="leaves.entitlements.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script
        alias="leaves"
        file="entitlements/create"
    />
</x-layouts.admin>
