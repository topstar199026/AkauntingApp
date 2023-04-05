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
            <x-tabs active="leave_types">
                <x-slot name="navs">
                    <x-tabs.nav-link
                        id="policies"
                        :name="trans_choice('leaves::general.policies', 2)"
                        :href="route('leaves.settings.policies.index')"
                    />
                    <x-tabs.nav
                        id="leave_types"
                        :name="trans_choice('leaves::general.leave_types', 2)"
                        active
                    />
                    <x-tabs.nav-link
                        id="years"
                        :name="trans_choice('leaves::general.years', 2)"
                        :href="route('leaves.settings.years.index')"
                    />
                </x-slot>
                <x-slot name="content">
                    <x-tabs.tab id="leave_types">
                        <x-table>
                            <x-table.thead>
                                <x-table.tr class="flex items-center px-1">
                                    <x-table.th class="w-6/12 sm:w-6/12">
                                        {{ trans('general.name') }}
                                    </x-table.th>
                                    <x-table.th class="w-6/12 sm:w-6/12">
                                        {{ trans('general.description') }}
                                    </x-table.th>
                                </x-table.tr>
                            </x-table.thead>
                            <x-table.tbody>
                                @foreach($leave_types as $leave_type)
                                    <x-table.tr>
                                        <x-table.td class="w-6/12 sm:w-6/12 truncate">
                                            @if(user()->can('update-leaves-settings'))
                                                <x-link
                                                    :href="route('leaves.settings.leave-types.edit', $leave_type->id)"
                                                    class="px-3 py-1.5 mb-3 sm:mb-0 rounded-xl text-sm font-medium leading-6"
                                                    override="class">
                                                    {{ $leave_type->name }}
                                                </x-link>
                                            @else
                                                {{ $leave_type->name }}
                                            @endif
                                        </x-table.td>
                                        <x-table.td class="w-6/12 sm:w-6/12 truncate">
                                            {{ $leave_type->description }}
                                        </x-table.td>

                                        <x-table.td kind="action">
                                            <x-table.actions :model="$leave_type" />
                                        </x-table.td>
                                    </x-table.tr>
                                @endforeach
                            </x-table.tbody>
                        </x-table>

                        <x-pagination :items="$leave_types" />
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
