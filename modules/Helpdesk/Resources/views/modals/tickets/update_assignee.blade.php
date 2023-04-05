<div class="py-1 px-5 bg-body">
    <div class="w-full mb-2">
        <akaunting-select
            title={{ trans_choice('helpdesk::general.ticket.assignee', 1) }}
            name="assignee_id"
            placeholder="{{ trans('helpdesk::general.ticket.assignee') }}"
            :options="{{ json_encode($assignees) }}"
            option_sortable="value"
            @change="onAssigneeUpdateModalChange"
            value="{{ $ticket->assignee_id }}">
        </akaunting-select>
    </div>
</div>
