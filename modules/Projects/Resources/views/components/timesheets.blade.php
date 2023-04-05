@if($timesheets->isNotEmpty())
    <x-table>
        <x-table.thead>
            <x-table.tr class="flex items-center px-1">
                <x-table.th class="w-4/12">
                    <x-slot name="first">
                        <x-sortablelink column="start_date" title="{{ trans('general.start_date') }}" />
                    </x-slot>
                    <x-slot name="second">
                        <x-sortablelink column="end_date" title="{{ trans('general.end_date') }}" />
                    </x-slot>
                </x-table.th>

                <x-table.th class="w-2/12" hidden-mobile>
                    <x-sortablelink column="member" :title="trans_choice('projects::general.members', 1)" />
                </x-table.th>

                <x-table.th class="w-4/12 sm:w-3/12">
                    <x-sortablelink column="task" :title="trans_choice('projects::general.tasks', 1)" />
                </x-table.th>

                <x-table.th class="w-4/12 sm:w-3/12" kind="right">
                    <x-sortablelink column="priority" :title="trans('projects::timesheets.time')" />
                </x-table.th>

            </x-table.tr>
        </x-table.thead>

        <x-table.tbody>
            @foreach($timesheets as $timesheet)
                <x-table.tr>
                    <x-table.td class="w-4/12">
                        <x-slot name="first">
                            <x-date :date="$timesheet->started_at" :format="company_date_format() . ' H:i'" />
                        </x-slot>
                        <x-slot name="second">
                            @if (! is_null($timesheet->ended_at))
                                <x-date :date="$timesheet->ended_at" :format="company_date_format() . ' H:i'" />
                            @else
                                {{ trans('projects::timesheets.ongoing') }}
                            @endif
                        </x-slot>
                    </x-table.td>

                    <x-table.td class="w-2/12" hidden-mobile>
                        {{ $timesheet->user->name }}
                    </x-table.td>

                    <x-table.td class="w-4/12 sm:w-3/12">
                        {{ $timesheet->task->name }}
                    </x-table.td>

                    <x-table.td class="w-4/12 sm:w-3/12" kind="right">
                        {{ $timesheet->elapsed_time }}
                    </x-table.td>

                    <x-table.td kind="action">
                        <x-table.actions :model="$timesheet" />
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>

    <x-pagination :items="$timesheets" />
    @else
    <x-projects::show.no-records name="timesheets" :project="$project" />
@endif
