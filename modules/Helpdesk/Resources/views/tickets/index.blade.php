<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('helpdesk::general.tickets', 2) }}
    </x-slot>

    <x-slot name="favorite"
        title="{{ trans_choice('helpdesk::general.tickets', 2) }}"
        icon="confirmation_number"
        route="helpdesk.tickets.index"
    ></x-slot>

    <x-slot name="buttons">
        @can('create-helpdesk-tickets')
            <x-link href="{{ route('helpdesk.tickets.create') }}" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('helpdesk::general.tickets', 1)]) }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="moreButtons">
        <x-dropdown id="dropdown-more-actions">
            <x-slot name="trigger">
                <span class="material-icons">more_horiz</span>
            </x-slot>

            @can('create-helpdesk-tickets')
                <x-dropdown.link href="{{ route('import.create', ['helpdesk', 'tickets']) }}">
                    {{ trans('import.import') }}
                </x-dropdown.link>
            @endcan

            <x-dropdown.link href="{{ route('helpdesk.tickets.export', request()->input()) }}">
                {{ trans('general.export') }}
            </x-dropdown.link>
        </x-dropdown>
    </x-slot>

    <x-slot name="content">
        @if ($tickets->count() || request()->get('search', false))
            <x-index.container>
                <x-index.search
                    search-string="Modules\Helpdesk\Models\Ticket"
                    bulk-action="Modules\Helpdesk\BulkActions\Tickets"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr class="flex items-center px-1">
                            <x-table.th class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                <x-index.bulkaction.all />
                            </x-table.th>

                            <x-table.th class="w-3/12">
                                <x-slot name="first">
                                    <x-sortablelink column="name" title="{{ trans('helpdesk::general.ticket.id') }}" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="subject" title="{{ trans('helpdesk::general.ticket.subject') }}" />
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-2/12 hidden sm:table-cell">
                                <x-sortablelink column="category.name" title="{{ trans_choice('general.categories', 1) }}" />
                            </x-table.th>

                            <x-table.th class="w-2/12">
                                <x-slot name="first">
                                    <x-sortablelink column="owner.name" title="{{ trans('helpdesk::general.ticket.reporter') }}" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="assignee.name" title="{{ trans('helpdesk::general.ticket.assignee') }}" />
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-2/12 hidden sm:table-cell">
                                <x-sortablelink column="status.name" title="{{ trans('helpdesk::general.ticket.status') }}" />
                            </x-table.th>

                            <x-table.th class="w-2/12">
                                <x-slot name="first">
                                    <x-sortablelink column="created_at" title="{{ trans('helpdesk::general.ticket.created') }}" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="updated_at" title="{{ trans('helpdesk::general.ticket.updated') }}" />
                                </x-slot>
                            </x-table.th>

                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach($tickets as $ticket)
                            <x-table.tr href="{{ route('helpdesk.tickets.show', $ticket->id) }}">
                                <x-table.td class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                    <x-index.bulkaction.single id="{{ $ticket->id }}" name="{{ $ticket->name }}" />
                                </x-table.td>

                                <x-table.td class="w-3/12 truncate">
                                    <x-slot name="first" class="flex items-center font-bold" override="class">
                                        {{ $ticket->name }}
                                    </x-slot>
                                    <x-slot name="second">
                                        {{ $ticket->subject }}
                                    </x-slot>
                                </x-table.td>

                                <x-table.td class="w-2/12 truncate hidden sm:table-cell">
                                    <div class="flex items-center">
                                        <x-index.category :model="$ticket->category" />
                                    </div>
                                </x-table.td>

                                <x-table.td class="w-2/12 truncate">
                                    <x-slot name="first" class="flex items-center font-bold" override="class">
                                        @isset($ticket->owner->id)
                                            <a href="{{ route('users.edit', $ticket->owner->id) }}">{{ $ticket->owner->name }}</a>
                                        @else
                                            {{ $ticket->owner->name }}
                                        @endisset
                                    </x-slot>
                                    <x-slot name="second">
                                        @if (isset($ticket->assignee->id))
                                            <a href="{{ route('users.edit', $ticket->assignee->id) }}">{{ $ticket->assignee->name }}</a>
                                        @else
                                            {{ $ticket->assignee->name }}
                                        @endif
                                    </x-slot>
                                </x-table.td>

                                <x-table.td class="w-2/12 truncate hidden sm:table-cell">
                                    <div class="flex items-center">
                                        <x-index.category :model="$ticket->status" />
                                    </div>
                                </x-table.td>

                                <x-table.td class="w-2/12 truncate">
                                    <x-slot name="first" class="flex items-center font-bold" override="class">
                                        <x-date date="{{ $ticket->created_at }}" />
                                    </x-slot>
                                    <x-slot name="second">
                                        <x-date date="{{ $ticket->updated_at }}" />
                                    </x-slot>
                                </x-table.td>

                                <x-table.td class="p-0" override="class">
                                    <x-table.actions :model="$ticket" />
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.tbody>
                </x-table>

                <x-pagination :items="$tickets" />
            </x-index.container>
        @else
            <x-empty-page group="helpdesk" page="tickets" />
        @endif
    </x-slot>

    <x-script alias="helpdesk" file="tickets" />
</x-layouts.admin>
