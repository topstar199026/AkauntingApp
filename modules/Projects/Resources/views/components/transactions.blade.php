@if($transactions->count())
    {{-- <x-index.search
        search-string="App\Models\Banking\Transaction"
        :route="['projects.transactions.index', $project]"
    /> --}}

    <x-table>
        <x-table.thead>
            <x-table.tr>
                <x-table.th class="w-4/12 sm:w-3/12">
                    <x-slot name="first">
                        <x-sortablelink column="paid_at" title="{{ trans('general.date') }}" />
                    </x-slot>
                    <x-slot name="second">
                        <x-sortablelink column="number" title="{{ trans_choice('general.numbers', 1) }}" />
                    </x-slot>
                </x-table.th>

                <x-table.th class="w-2/12" hidden-mobile>
                    <x-slot name="first">
                        <x-sortablelink column="type" title="{{ trans_choice('general.types', 1) }}" />
                    </x-slot>
                    <x-slot name="second">
                        <x-sortablelink column="category.name" title="{{ trans_choice('general.categories', 1) }}" />
                    </x-slot>
                </x-table.th>

                <x-table.th class="w-4/12 sm:w-3/12">
                    <x-sortablelink column="account.name" title="{{ trans_choice('general.accounts', 1) }}" />
                </x-table.th>

                <x-table.th class="w-2/12" hidden-mobile>
                    <x-slot name="first">
                        <x-sortablelink column="contact.name" title="{{ trans_choice('general.contacts', 1) }}" />
                    </x-slot>
                    <x-slot name="second">
                        <x-sortablelink column="document.document_number" title="{{ trans_choice('general.documents', 1) }}" />
                    </x-slot>
                </x-table.th>

                <x-table.th class="w-4/12 sm:w-2/12" kind="amount">
                    <x-sortablelink column="amount" title="{{ trans('general.amount') }}" />
                </x-table.th>
            </x-table.tr>
        </x-table.thead>

        <x-table.tbody>
            @foreach($transactions as $item)
                <x-table.tr href="{{ route('transactions.show', $item->financialable_id) }}">
                    <x-table.td class="w-4/12 sm:w-3/12">
                        <x-slot name="first" class="font-bold truncate" override="class">
                            <x-date date="{{ $item->paid_at }}" />
                        </x-slot>
                        <x-slot name="second">
                            {{ $item->number }}
                        </x-slot>
                    </x-table.td>

                    <x-table.td class="w-2/12" hidden-mobile>
                        <x-slot name="first">
                            {{ $item->type_title }}
                        </x-slot>
                        <x-slot name="second" class="flex items-center">
                            <x-index.category :model="$item->category" />
                        </x-slot>
                    </x-table.td>

                    <x-table.td class="w-4/12 sm:w-3/12">
                        {{ $item->account->name }}
                    </x-table.td>

                    <x-table.td class="w-2/12" hidden-mobile>
                        <x-slot name="first">
                            {{ $item->contact->name }}
                        </x-slot>
                        <x-slot name="second" class="w-20 font-normal group">
                            @if ($item->document)
                                <div data-tooltip-target="tooltip-information-{{ $item->document_id }}" data-tooltip-placement="left" override="class">
                                    <x-link href="{{ route($item->route_name, $item->route_id) }}" class="font-normal truncate border-b border-black border-dashed" override="class">
                                        {{ $item->document->document_number }}
                                    </x-link>

                                    <div class="w-28 absolute h-10 -ml-12 -mt-6">
                                    </div>

                                    <x-documents.index.information :document="$item->document" />
                                </div>
                            @else
                                <x-empty-data />
                            @endif
                        </x-slot>
                    </x-table.td>

                    <x-table.td class="relative w-4/12 sm:w-2/12" kind="amount">
                        <x-money :amount="$item->amount" :currency="$item->currency_code" convert />
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>

    <x-pagination :items="$transactions" />
    @else
    <x-show.no-records
        image="modules/Projects/Resources/assets/img/no_records/transactions.png"
        :description="trans('projects::general.no_records.transactions')"
        :url="route('transactions.index')"
    />
@endif
