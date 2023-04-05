<div class="py-1 px-5 bg-body">
    <div class="w-full mb-2">
        <akaunting-select
            title={{ trans_choice('helpdesk::general.priorities', 1) }}
            name="priority_id"
            :options="{{ json_encode($priorities) }}"
            option_sortable="key"
            @change="onPriorityUpdateModalChange"
            value="{{ $ticket->priority_id }}">
        </akaunting-select>
    </div>
</div>
