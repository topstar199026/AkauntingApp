@if ($entitlements->count())
    <x-index.container>
        <x-table>
            <x-table.thead>
                <x-table.tr class="flex items-center px-1">
                    <x-table.th class="w-3/12 md:w-4/12">
                        <x-sortablelink
                            column="employee"
                            :title="trans_choice('employees::general.employees', 1)"
                        />
                    </x-table.th>

                    <x-table.th class="w-2/12">
                        <x-sortablelink
                            column="policy"
                            :title="trans_choice('leaves::general.policies', 1)"
                        />
                    </x-table.th>

                    <x-table.th class="w-2/12 md:w-1/12">
                        <x-sortablelink
                            column="year"
                            :title="trans_choice('leaves::general.years', 1)"
                        />
                    </x-table.th>

                    <x-table.th class="w-2/12">
                        <x-sortablelink
                            column="days"
                            :title="trans('leaves::policies.days')"
                        />
                    </x-table.th>

                    <x-table.th class="w-2/12">
                        <x-sortablelink
                            column="remaining_days"
                            :title="trans('leaves::entitlements.available')"
                        />
                    </x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach($entitlements as $entitlement)
                    <x-table.tr class="relative flex items-center border-b hover:bg-gray-100 px-1 group transition-all">
                        <x-table.td class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                            <x-index.bulkaction.single id="{{ $entitlement->id }}" name="entitlement_{{ $entitlement->id }}" />
                        </x-table.td>

                        <x-table.td class="w-3/12 md:w-4/12 truncate">
                            {{ optional($entitlement->employee->contact)->name ?? trans('general.na') }}
                        </x-table.td>

                        <x-table.td class="w-2/12 truncate">
                            {{ $entitlement->policy->name }}
                        </x-table.td>

                        <x-table.td class="w-2/12 md:w-1/12 truncate">
                            {{ $entitlement->policy->year->name }}
                        </x-table.td>

                        <x-table.td class="w-2/12 truncate">
                            {{ $entitlement->policy->days }}
                        </x-table.td>

                        <x-table.td class="w-2/12 truncate">
                            {{ $entitlement->remaining_days }}
                        </x-table.td>

                        <x-table.td kind="action">
                            <x-table.actions :model="$entitlement" />
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table>
    </x-index.container>

    <x-pagination :items="$entitlements" />
@else
    <x-show.no-records 
        description="{{ trans('leaves::general.empty.entitlements') }}"
        url="{{ $route }}"
        text-action="{{ trans('modules.learn_more') }}" 
        image="{{ asset('modules/Leaves/Resources/assets/img/empty_pages/entitlements.png') }}"
    />
@endif
