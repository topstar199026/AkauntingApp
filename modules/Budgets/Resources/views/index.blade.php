<x-layouts.admin>
    <x-slot name="title">
        {{ trans('budgets::general.name') }}
    </x-slot>

    <x-slot name="buttons">
        @can('create-budgets-budgets')
            <x-link href="{{ route('budgets.create') }}" kind="primary">
                {{ trans('general.add_new') }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="content">
        <x-index.container>

            @if($is_double_entry_installed === false)
                <div class="w-full bg-red-100 text-red-600 p-3 rounded-sm font-semibold text-xs">
                    You need to have the <a class="underline text-red-800" href="{{ route('apps.app.show', ['alias' => 'double-entry']) . '?' . http_build_query(['utm_source' => 'Budgets', 'utm_medium' => 'App', 'utm_campaign' => 'DoubleEntry']) }}">Double Entry</a> app is installed and enabled for this company to create a budget.
                </div>
            @endif

            @if($budgets->count() > 0)
            <div class="card" id="budgets-module">
                <budget-list inline-template>
                    <div>
                        <x-table>
                            <x-table.thead>
                                <x-table.tr class="flex items-center px-1">
                                    <x-table.th class="w-5/12">{{ trans('general.name') }}</x-table.th>
                                    <x-table.th class="w-4/12">{{ trans_choice('budgets::general.financial_year', 1) }}</x-table.th>
                                    <x-table.th class="w-3/12">{{ trans('budgets::general.period') }}</x-table.th>
                                </x-table.tr>
                            </x-table.thead>

                            <x-table.tbody>
                                @foreach ($budgets as $budget)
                                    <x-table.tr href="{{ route('budgets.show', $budget->id) }}" class="relative flex items-center border-b hover:bg-gray-100 px-1 group transition-[height]">
                                        <x-table.td class="w-5/12">
                                            <a href="{{ route('budgets.show', $budget) }}">
                                                {{ $budget->name }}
                                            </a>
                                        </x-table.td>
                                        <x-table.td class="w-4/12">
                                            {{ $budget->formatted_financial_year}}
                                        </x-table.td>
                                        <x-table.td class="w-3/12">
                                            {{ trans('general.'.$budget->period) }}
                                        </x-table.td>
                                        <x-table.td class="p-0" override="class">
                                            <x-table.actions :model="$budget" />
                                        </x-table.td>
                                    </x-table.tr>
                                @endforeach
                            </x-table.tbody>
                        </x-table>
                        <confirm-delete-modal :confirm="confirm" @cancel="cancelDelete" />
                    </div>
                </budget-list>
            </div>

            <x-pagination :items="$budgets" />
            @else
                <div class="card">
                    <div class="text-center">
                        <div class="p-5">
                            <img class="mx-auto" src="{{ asset('public/img/empty_pages/revenues.png') }}" alt="Budgets"/>
                        </div>

                        <div class="text-center p-5">
                            <p class="text-justify description">
                                {{ trans('budgets::general.description') }}
                            </p>

                            @can('create-budgets-budgets')
                                <x-link href="{{ route('budgets.create') }}" kind="primary">
                                    {{ trans('general.title.create', ['type' => trans_choice('budgets::general.budget', 1)]) }}
                                </x-link>
                            @endcan
                        </div>
                    </div>
                </div>
            @endif
        </x-index.container>
    </x-slot>

    <x-script alias="budgets" file="budgets" />
</x-layouts.admin>
