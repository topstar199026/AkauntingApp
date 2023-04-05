<x-layouts.portal>
    <x-slot name="title">{{ trans('appointments::general.name') }}</x-slot>

    <x-slot name="content">
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

                        <x-table.th class="w-full">
                            <x-sortablelink column="appointment_name" title="{{ trans('appointments::general.appointment_name') }}" />
                        </x-table.th>
                    </x-table.tr>
                </x-table.thead>

                <x-table.tbody>
                    @foreach($appointments as $item)                           
                        <x-table.tr data-table-list class="relative flex items-center border-b hover:bg-gray-100 px-1 group">
                            <x-table.td class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->appointment_name }}" />
                            </x-table.td>

                            <x-table.td class="w-full">
                                {{ $item->appointment_name }}
                            </x-table.td>

                            <x-table.td class="p-0" override="class">
                                <div class="absolute ltr:right-12 rtl:left-12 -top-4 hidden items-center group-hover:flex">
                                    <a href="{{ route('portal.appointments.appointments.show', $item->id) }}" class="relative bg-white hover:bg-gray-100 border py-0.5 px-1 cursor-pointer index-actions group">
                                        <span class="material-icons-outlined text-purple text-lg">visibility</span>
                                        <div class="inline-block absolute invisible z-20 py-1 px-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 tooltip-content -top-10 -left-2" data-tooltip-placement="top">
                                            <span>{{ trans('general.show') }}</span>
                                            <div class="w-2 h-2 tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </a>                       
                                </div>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.tbody>
            </x-table>

            <x-pagination :items="$appointments" />
        </x-index.container>
    </x-slot>

    @push('scripts_start')
        <script type="text/javascript">
            var events = [];
            var calendar_locale = '{{ strtolower(language()->getShortCode()) }}';
            var calendar_country = '{{ setting('company.country', 'GB') }}';
        </script>
    @endpush

    <x-script alias="appointments" file="portal" />
</x-layouts.portal>
