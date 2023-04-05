<x-layouts.portal>
    <x-slot name="title">
        {{ trans_choice('helpdesk::general.tickets', 2) }}
    </x-slot>

    <x-slot name="buttons">
        @can('create-helpdesk-portal-tickets')
            <x-link href="{{ route('portal.helpdesk.tickets.create') }}" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('helpdesk::general.tickets', 1)]) }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="content">
        @if ($tickets->count() || request()->get('search', false))
            <x-index.container>
                <x-index.search search-string="Modules\Helpdesk\Models\Portal\Ticket" />

                <x-table>
                    <x-table.thead>
                        <x-table.tr class="flex tickets-center px-1">

                            <x-table.th class="w-4/12">
                                <x-slot name="first">
                                    <x-sortablelink column="name"
                                        title="{{ trans('helpdesk::general.ticket.id') }}" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="subject"
                                        title="{{ trans('helpdesk::general.ticket.subject') }}" />
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-2/12 hidden sm:table-cell">
                                <x-sortablelink column="category.name"
                                    title="{{ trans_choice('general.categories', 1) }}" />
                            </x-table.th>

                            <x-table.th class="w-2/12">
                                <x-slot name="first">
                                    <x-sortablelink column="owner.name"
                                        title="{{ trans('helpdesk::general.ticket.reporter') }}" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="assignee.name"
                                        title="{{ trans('helpdesk::general.ticket.assignee') }}" />
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-2/12 hidden sm:table-cell">
                                <x-sortablelink column="status.name"
                                    title="{{ trans('helpdesk::general.ticket.status') }}" />
                            </x-table.th>

                            <x-table.th class="w-2/12">
                                <x-slot name="first">
                                    <x-sortablelink column="created_at"
                                        title="{{ trans('helpdesk::general.ticket.created') }}" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="updated_at"
                                        title="{{ trans('helpdesk::general.ticket.updated') }}" />
                                </x-slot>
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach ($tickets as $ticket)
                            @if ($ticket->created_by == user_id())
                                <x-table.tr href="{{ route('portal.helpdesk.tickets.show', $ticket->id) }}">

                                    <x-table.td class="w-4/12 truncate">
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
                                            {{ $ticket->owner->name }}
                                        </x-slot>
                                        <x-slot name="second">
                                            {{ $ticket->assignee->name }}
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
                                </x-table.tr>
                            @endif
                        @endforeach
                    </x-table.tbody>
                </x-table>

                <x-pagination :items="$tickets" />
            </x-index.container>
        @else
            <x-empty-page group="portal.helpdesk" page="tickets" hide-button-import />
        @endif
    </x-slot>

    <x-script alias="helpdesk" file="tickets" />
</x-layouts.portal>
