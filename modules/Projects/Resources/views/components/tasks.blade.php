@if($tasks->isNotEmpty())
    <x-table>
        <x-table.thead>
            <x-table.tr>
                <x-table.th class="w-4/12 sm:w-4/12">
                    <x-slot name="first">
                        <x-sortablelink column="start_date" title="{{ trans('general.start_date') }}" />
                    </x-slot>
                    <x-slot name="second">
                        <x-sortablelink column="end_date" title="{{ trans('general.end_date') }}" />
                    </x-slot>
                </x-table.th>

                <x-table.th class="w-3/12">
                    {{ trans_choice('general.statuses', 1) }}
                </x-table.th>

                <x-table.th class="w-3/12 sm:w-3/12">
                    <x-sortablelink column="name" title="{{ trans('general.name') }}" />
                </x-table.th>

                <x-table.th class="w-2/12 sm:w-2/12" kind="right">
                    {{ trans_choice('projects::general.priorities', 1) }}
                </x-table.th>
            </x-table.tr>
        </x-table.thead>

        <x-table.tbody>
            @foreach($tasks as $item)
                <x-table.tr>
                    <x-table.td class="w-4/12 sm:w-4/12">
                        <x-slot name="first">
                            {{ company_date($item->started_at) }}
                        </x-slot>
                        <x-slot name="second">
                            {{ empty($item->deadline_at) ? '-' : company_date($item->deadline_at) }}
                        </x-slot>
                    </x-table.td>

                    <x-table.td class="w-3/12">
                        <span class="flex items-center">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-xl bg-{{ $item->status_color }} text-text-{{ $item->status_color }}">
                                {{ trans("projects::general.$item->status") }}
                            </span>
                        </span>
                    </x-table.td>

                    <x-table.td class="w-3/12 sm:w-3/12">
                        {{ $item->name }}
                    </x-table.td>

                    <x-table.td class="w-2/12" kind="right">
                        @if($item->priority)
                            {{ trans("projects::general.$item->priority") }}
                        @else
                            <x-empty-data />
                        @endif
                    </x-table.td>

                    <x-table.td kind="action">
                        <x-table.actions :model="$item" />
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>

    <x-pagination :items="$tasks" />
    @else
    <x-projects::show.no-records name="tasks" :project="$project" />
@endif
