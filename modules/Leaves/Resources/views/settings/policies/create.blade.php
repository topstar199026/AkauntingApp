<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.new', ['type' => trans('leaves::general.leave_policy')]) }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="policy" route="leaves.settings.policies.store">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head
                            :title="trans('general.general')"
                            :description="trans('leaves::policies.form_description.general')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text
                            name="name"
                            :label="trans('general.name')"
                        />

                        <x-form.group.select
                            name="leave_type_id"
                            :label="trans_choice('leaves::general.leave_types', 1)"
                            :options="$leave_types"
                            add-new
                            path="route('leaves.modals.settings.leave-types.create')"
                            field="['key' => 'id', 'value' => 'name']"
                        />

                        <x-form.group.select
                            name="year_id"
                            :label="trans_choice('leaves::general.leave_year', 1)"
                            :options="$leave_years"
                            add-new
                            path="route('leaves.modals.settings.years.create')"
                            field="['key' => 'id', 'value' => 'name']"
                        />

                        <x-form.group.select
                            name="department_id"
                            :label="trans_choice('employees::general.departments', 1)"
                            :options="$departments"
                            add-new
                            path="route('employees.modals.departments.create')"
                            field="['key' => 'id', 'value' => 'name']"
                            not-required
                        />

                        <x-form.group.select
                            name="gender"
                            :label="trans('employees::employees.gender')"
                            :options="$genders"
                            not-required
                        />

                        <x-form.group.text
                            name="days"
                            :label="trans('leaves::policies.days')"
                        />

                        <x-form.group.text
                            name="applicable_after"
                            :label="trans('leaves::policies.applicable_after')"
                        />

                        <x-form.group.text
                            name="carryover_days"
                            :label="trans('leaves::policies.carryover_days')"
                        />

                        <x-form.group.toggle
                            name="is_paid"
                            :label="trans('leaves::policies.paid')"
                            value="true"
                        />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="leaves.settings.policies.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script
        alias="leaves"
        file="settings/policies"
    />
</x-layouts.admin>
