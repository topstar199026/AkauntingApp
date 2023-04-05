<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.new', ['type' => trans_choice('helpdesk::general.tickets', 1)]) }}
    </x-slot>

    <x-slot name="favorite"
        title="{{ trans('general.title.new', ['type' => trans_choice('helpdesk::general.tickets', 1)]) }}" icon="confirmation_number"
        route="helpdesk.tickets.create"></x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="ticket" route="helpdesk.tickets.store">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}"
                            description="{{ trans('helpdesk::general.form_description.create') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="subject" label="{{ trans('helpdesk::general.ticket.subject') }}" />

                        <x-form.group.category type="ticket" />

                        <x-form.group.select multiple name="document_ids"
                            label="{{ trans('helpdesk::general.ticket.related_to') }}" :options="$documents"
                            not-required form-group-class="sm:col-span-3 el-select-tags-pl-38" />

                        <x-form.group.select name="status_id"
                            label="{{ trans_choice('helpdesk::general.statuses', 1) }}" :options="$statuses"
                            :selected="$status_id" form-group-class="sm:col-span-3 el-select-tags-pl-38"
                            :readonly="true" />

                        <x-form.group.select name="priority_id"
                            label="{{ trans_choice('helpdesk::general.priorities', 1) }}" :options="$priorities"
                            :selected="$priority_id" form-group-class="sm:col-span-3 el-select-tags-pl-38" />

                        <x-form.group.select name="assignee_id"
                            label="{{ trans('helpdesk::general.ticket.assignee') }}" :options="$assignees"
                            not-required form-group-class="sm:col-span-3 el-select-tags-pl-38" />

                        <x-form.group.textarea name="message"
                            label="{{ trans('helpdesk::general.ticket.message') }}" />

                        <x-form.group.attachment />

                        <x-form.input.hidden name="name" />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="helpdesk.tickets.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="helpdesk" file="tickets" />
</x-layouts.admin>
