<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.new', ['type' => trans_choice('leaves::general.leave_types', 1)]) }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="leave-type" route="leaves.settings.leave-types.store">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head
                            :title="trans('general.general')"
                            :description="trans('leaves::leave_types.form_description.general')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text
                            name="name"
                            :label="trans('general.name')"
                        />

                        <x-form.group.textarea
                            name="description"
                            :label="trans('general.description')"
                            not-required
                        />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="leaves.settings.leave-types.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script
        alias="leaves"
        file="settings/leave_types"
    />
</x-layouts.admin>
