<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.new', ['type' => trans('leaves::general.leave_year')]) }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="year" route="leaves.settings.years.store">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head
                            :title="trans('general.general')"
                            :description="trans('leaves::years.form_description.general')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text
                            name="name"
                            :label="trans('general.name')"
                        />

                        <x-form.group.date
                            name="start_date"
                            :label="trans('general.start_date')"
                            :show-date-format="company_date_format()"
                            date-format="Y-m-d"
                            change="setEndMinDate"
                        />

                        <x-form.group.date
                            name="end_date"
                            :label="trans('general.end_date')"
                            :show-date-format="company_date_format()"
                            date-format="Y-m-d"
                            min-date="min_end_date"
                            min-date-dynamic="true"
                        />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="leaves.settings.years.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script
        alias="leaves"
        file="settings/years"
    />
</x-layouts.admin>
