<x-layouts.admin>
    <x-slot name="title">{{ trans('appointments::general.name') }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans('appointments::general.name') }}"
        icon="today"
        route="appointments.appointments.index"
    ></x-slot>

    <x-slot name="buttons">
        @can('create-appointments-appointments')
            <x-link href="{{ route('appointments.appointments.create') }}" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('appointments::general.appointments', 1)]) }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="content">
        @if ($appointments->count() || request()->get('search', false))
            <x-index.container>
                <x-index.search
                    search-string="Modules\Appointments\Models\Appointment"
                    bulk-action="Modules\Appointments\BulkActions\Appointments"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr class="flex items-center px-1">
                            <x-table.th class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                <x-index.bulkaction.all />
                            </x-table.th>

                            <x-table.th class="w-6/12">
                                <x-sortablelink column="appointment_name" title="{{ trans('appointments::general.appointment_name') }}" />
                            </x-table.th>

                            <x-table.th class="w-3/12 hidden sm:table-cell">
                                {{ trans('appointments::general.owner') }}
                            </x-table.th>

                            <x-table.th class="w-3/12 hidden sm:table-cell">
                                {{ trans('appointments::general.appointment_type') }}
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach($appointments as $item)                           
                            <x-table.tr href="{{ route('appointments.appointments.show', $item->id) }}" data-table-list class="relative flex items-center border-b hover:bg-gray-100 px-1 group">
                                <x-table.td class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                    <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->appointment_name }}" />
                                </x-table.td>

                                <x-table.td class="w-6/12">
                                    <div class="truncate">
                                        {{ $item->appointment_name }}
                                    </div>

                                    @if (! $item->enabled)
                                        <x-index.disable text="{{ trans_choice('appointments::general.appointments', 1) }}" />
                                    @endif
                                </x-table.td>

                                <x-table.td class="w-3/12 truncate hidden sm:table-cell">
                                    {{ trans('appointments::general.' . $item->owner) }}
                                </x-table.td>

                                <x-table.td class="w-3/12 hidden sm:table-cell">
                                    {{ trans('appointments::general.' . $item->appointment_type) }}
                                </x-table.td>

                                <x-table.td class="p-0" override="class">
                                    <x-table.actions :model="$item" />
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.tbody>
                </x-table>

                <x-pagination :items="$appointments" />
            </x-index.container>
        @else
            <x-empty-page group="appointments" page="appointments" hide-button-import />
        @endif
    </x-slot>

    @push('scripts_start')
        <script type="text/javascript">
            var events = [];
            var calendar_locale = '{{ strtolower(language()->getShortCode()) }}';
            var calendar_country = '{{ setting('company.country', 'GB') }}';
        </script>
    @endpush

    <x-script alias="appointments" file="appointments" />
</x-layouts.admin>