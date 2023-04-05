<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('leaves::general.entitlements', 2) }}
    </x-slot>

    <x-slot name="favorite"
        :title="trans_choice('leaves::general.entitlements', 2)"
        icon="gavel"
        route="leaves.entitlements.index"
    ></x-slot>

    <x-slot name="buttons">
        @can('create-leaves-entitlements')
            <x-link :href="route('leaves.entitlements.create')" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('leaves::general.entitlements', 1)]) }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="content">
        @if ($entitlements->count() || request()->get('search', false))
            <x-leaves::entitlements-widgets />

            <x-index.container>
                <x-index.search
                    search-string="Modules\Leaves\Models\Entitlement"
                    bulk-action="Modules\Leaves\BulkActions\Entitlements"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr>
                            <x-table.th kind="bulkaction">
                                <x-index.bulkaction.all />
                            </x-table.th>
                            <x-table.th class="w-4/12 sm:w-3/12 md:w-4/12">
                                <x-sortablelink
                                    column="employee"
                                    :title="trans_choice('employees::general.employees', 1)"
                                />
                            </x-table.th>

                            <x-table.th class="w-4/12 sm:w-3/12">
                                <x-sortablelink
                                    column="policy"
                                    :title="trans_choice('leaves::general.policies', 1)"
                                />
                            </x-table.th>

                            <x-table.th class="w-2/12 md:w-1/12" hidden-mobile>
                                <x-sortablelink
                                    column="year"
                                    :title="trans_choice('leaves::general.years', 1)"
                                />
                            </x-table.th>

                            <x-table.th class="w-4/12 sm:w-2/12">
                                <x-sortablelink
                                    column="days"
                                    :title="trans('leaves::policies.days')"
                                />
                            </x-table.th>

                            <x-table.th class="w-2/12" hidden-mobile>
                                <x-sortablelink
                                    column="remaining_days"
                                    :title="trans('leaves::entitlements.available')"
                                />
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>
                    <x-table.tbody>
                        @foreach($entitlements as $entitlement)
                            <x-table.tr>
                                <x-table.td kind="bulkaction">
                                    <x-index.bulkaction.single id="{{ $entitlement->id }}" name="entitlement_{{ $entitlement->id }}" />
                                </x-table.td>

                                <x-table.td class="w-4/12 sm:w-3/12 md:w-4/12 truncate">
                                    {{ optional($entitlement->employee->contact)->name ?? trans('general.na') }}
                                </x-table.td>

                                <x-table.td class="w-4/12 sm:w-3/12 truncate">
                                    {{ $entitlement->policy->name }}
                                </x-table.td>

                                <x-table.td class="w-2/12 md:w-1/12 truncate" hidden-mobile>
                                    {{ $entitlement->policy->year->name }}
                                </x-table.td>

                                <x-table.td class="w-4/12 sm:w-2/12 truncate">
                                    {{ $entitlement->policy->days }}
                                </x-table.td>

                                <x-table.td class="w-2/12 truncate" hidden-mobile>
                                    {{ $entitlement->remaining_days }}
                                </x-table.td>

                                <x-table.td kind="action">
                                    <x-table.actions :model="$entitlement" />
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.tbody>
                </x-table>


                <x-pagination :items="$entitlements" />
            </x-index.container>
        @else
            <x-empty-page
                group="leaves"
                page="entitlements"
                url-docs-path="https://akaunting.com/docs/app-manual/hr/leaves"
                image-empty-page="modules/Leaves/Resources/assets/img/empty_pages/entitlements.png"
                text-empty-page="{{ trans('leaves::general.empty.entitlements') }}"
                route-create="leaves.entitlements.create"
                text-page="leaves::general.entitlements"
                hide-button-import
            />
        @endif
    </x-slot>

    <x-script
        alias="leaves"
        file="entitlements/index"
    />
</x-layouts.admin>
