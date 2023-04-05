<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.new', ['type' => trans_choice('projects::general.projects', 1)]) }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form
                id="project"
                route="projects.projects.store">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head
                            :title="trans('general.general')"
                            :description="trans('projects::projects.form_description.general')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text
                            name="name"
                            :label="trans('general.name')"
                        />

                        <x-form.group.select
                            name="customer_id"
                            :label="trans_choice('general.contacts', 1)"
                            :options="$contacts"
                            add-new
                            :path="route('modals.customers.create')"
                        />

                        <x-form.group.textarea
                            name="description"
                            :label="trans('general.description')"
                            not-required
                        />

                        <x-form.group.date
                            name="started_at"
                            :label="trans('general.start_date')"
                            value="{{ Date::now()->toDateString() }}"
                            :show-date-format="company_date_format()"
                        />

                        <x-form.group.date
                            name="ended_at"
                            :label="trans('general.end_date')"
                            :show-date-format="company_date_format()"
                            not-required
                        />

                        <x-form.group.choose
                            name="members"
                            :label="trans_choice('projects::general.members', 2)"
                            :options="$users"
                            multiple
                            collapse
                        />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head
                            :title="trans('projects::projects.billing')"
                            :description="trans('projects::projects.form_description.billing')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.select
                            name="billing_type"
                            :label="trans('projects::general.billing_type')"
                            :options="$billing_types"
                            change="changeBillingRate"
                        />

                        <x-form.group.money
                            name="rate_per_hour"
                            :label="trans('projects::general.rate_per_hour')"
                            :currency="$currency"
                            v-show="is_rate_per_hour_visible"
                            value="0"
                        />

                        <x-form.group.money
                            name="total_rate"
                            :label="trans('projects::general.total_rate')"
                            :currency="$currency"
                            v-show="is_total_rate_visible"
                            value="0"
                        />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head
                            :title="trans_choice('general.others', 1)"
                            :description="trans('projects::projects.form_description.other')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <x-projects::form.attachment />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="projects.projects.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script
        alias="projects"
        file="projects"
    />
    <x-custom
        alias="projects"
        file="projects"
    />
</x-layouts.admin>
