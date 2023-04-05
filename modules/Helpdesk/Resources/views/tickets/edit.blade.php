<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.edit', ['type' => trans_choice('helpdesk::general.tickets', 1)]) . ' ' . $ticket->name }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="ticket" method="PATCH" :route="['helpdesk.tickets.update', $ticket->id]" :model="$ticket">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}"
                            description="{{ trans('helpdesk::general.form_description.show') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <div class="sm:col-span-2 flex flex-col text-sm mb-5">
                            <div class="font-medium">{{ trans('helpdesk::general.ticket.created') }}</div>
                            <x-date date="{{ $ticket->created_at }}" />{{ $ticket->created_at->format('H:i') }}
                        </div>

                        <div class="sm:col-span-2 flex flex-col text-sm mb-5">
                            <div class="font-medium">{{ trans('helpdesk::general.ticket.updated') }}</div>
                            <x-date date="{{ $ticket->updated_at }}" />{{ $ticket->updated_at->format('H:i') }}
                        </div>

                        <div class="sm:col-span-2 flex flex-col text-sm mb-5">
                            <div class="font-medium">{{ trans('helpdesk::general.ticket.reporter') }}</div>
                            <span>{{ $ticket->owner->name }}</span>
                        </div>
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('helpdesk::general.details') }}"
                            description="{{ trans('helpdesk::general.form_description.edit') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="subject" label="{{ trans('helpdesk::general.ticket.subject') }}" />

                        <x-form.group.category type="ticket" />

                        <x-form.group.select multiple add-new name="document_ids"
                            label="{{ trans('helpdesk::general.ticket.related_to') }}" :options="$documents" not-required
                            form-group-class="sm:col-span-3 el-select-tags-pl-38" />

                        <x-form.group.select name="status_id"
                            label="{{ trans_choice('helpdesk::general.statuses', 1) }}" :options="$statuses"
                            :selected="$ticket->status_id" not-required form-group-class="sm:col-span-3 el-select-tags-pl-38"
                            :readonly="true" />

                        <x-form.group.select name="priority_id"
                            label="{{ trans_choice('helpdesk::general.priorities', 1) }}" :options="$priorities"
                            :selected="$ticket->priority_id" not-required form-group-class="sm:col-span-3 el-select-tags-pl-38" />

                        <x-form.group.select name="assignee_id"
                            label="{{ trans('helpdesk::general.ticket.assignee') }}" :options="$assignees"
                            :selected="$ticket->assignee_id" not-required form-group-class="sm:col-span-3 el-select-tags-pl-38" />

                        <x-form.group.textarea name="message"
                            label="{{ trans('helpdesk::general.ticket.message') }}" />

                        <x-form.group.attachment />
                    </x-slot>
                </x-form.section>

                @can('update-helpdesk-tickets')
                    <x-form.section>
                        <x-slot name="foot">
                            <x-form.buttons cancel-route="helpdesk.tickets.index" />
                        </x-slot>
                    </x-form.section>
                @endcan
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="helpdesk" file="tickets" />
</x-layouts.admin>
