<x-layouts.admin>
    <x-slot name="title">
        {{ trans('leaves::general.name') }}
    </x-slot>

    <x-slot name="buttons">
        <x-link :href="route('leaves.settings.policies.create')" kind="primary">
            {{ trans('general.title.new', ['type' => trans_choice('leaves::general.policies', 1)]) }}
        </x-link>
        <x-link :href="route('leaves.settings.leave-types.create')" kind="primary">
            {{ trans('general.title.new', ['type' => trans_choice('leaves::general.leave_types', 1)]) }}
        </x-link>
        <x-link :href="route('leaves.settings.years.create')" kind="primary">
            {{ trans('general.title.new', ['type' => trans_choice('leaves::general.years', 1)]) }}
        </x-link>
    </x-slot>
    
    <x-slot name="content">
        <x-index.container>
            <x-tabs active="years">
                <x-slot name="navs">
                    <x-tabs.nav-link
                        id="policies"
                        :name="trans_choice('leaves::general.policies', 2)"
                        :href="route('leaves.settings.policies.index')"
                    />
                    <x-tabs.nav-link
                        id="leave_types"
                        :name="trans_choice('leaves::general.leave_types', 2)"
                        :href="route('leaves.settings.leave-types.index')"
                    />
                    <x-tabs.nav
                        id="years"
                        :name="trans_choice('leaves::general.years', 2)"
                        active
                    />
                </x-slot>
                <x-slot name="content">
                    <x-tabs.tab id="years">
                        <x-table>
                            <x-table.thead>
                                <x-table.tr class="flex items-center px-1">
                                    <x-table.th class="w-4/12 sm:w-4/12">
                                        {{ trans('general.name') }}
                                    </x-table.th>
                                    <x-table.th class="w-4/12 sm:w-4/12">
                                        {{ trans('general.start_date') }}
                                    </x-table.th>
                                    <x-table.th class="w-4/12 sm:w-4/12">
                                        {{ trans('general.end_date') }}
                                    </x-table.th>
                                </x-table.tr>
                            </x-table.thead>
                            <x-table.tbody>
                                @foreach($years as $year)
                                    <x-table.tr>
                                        <x-table.td class="w-4/12 sm:w-4/12 truncate">
                                            @if(user()->can('update-leaves-settings'))
                                                <x-link
                                                    :href="route('leaves.settings.years.edit', $year->id)"
                                                    class="px-3 py-1.5 mb-3 sm:mb-0 rounded-xl text-sm font-medium leading-6"
                                                    override="class">
                                                    {{ $year->name }}
                                                </x-link>
                                            @else
                                                {{ $year->name }}
                                            @endif
                                        </x-table.td>
                                        <x-table.td class="w-4/12 sm:w-4/12 truncate">
                                            @date($year->start_date)
                                        </x-table.td>
                                        <x-table.td class="w-4/12 sm:w-4/12 truncate">
                                            @date($year->end_date)
                                        </x-table.td>

                                        <x-table.td kind="action">
                                            <x-table.actions :model="$year" />
                                        </x-table.td>
                                    </x-table.tr>
                                @endforeach
                            </x-table.tbody>
                        </x-table>

                        <x-pagination :items="$years" />
                    </x-tabs.tab>
                </x-slot>
            </x-tabs>
        </x-index.container>
    </x-slot>

    <x-script
        alias="leaves"
        file="settings/edit"
    />
</x-layouts.admin>
