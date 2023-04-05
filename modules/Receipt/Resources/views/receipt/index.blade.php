<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('receipt::general.title', 2) }}
    </x-slot>

    <x-slot name="buttons">
        @can('create-receipt-receipts')
            <x-link href="{{ route('receipt.import') }}" kind="primary">
                {{ trans('general.add_new') }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="moreButtons">
        <x-dropdown id="dropdown-more-actions">
            <x-slot name="trigger">
                <span class="material-icons">more_horiz</span>
            </x-slot>

            <x-dropdown.link href="{{ route('receipt.export', request()->input()) }}">
                {{ trans('general.export') }}
            </x-dropdown.link>
        </x-dropdown>
    </x-slot>

    <x-slot name="content">
        <x-index.container>
            <x-index.search
                search-string="Modules\Receipt\Models\Receipt"
                bulk-action="Modules\Receipt\BulkActions\Receipt"
            />

            <x-table>
                <x-table.thead>
                    <x-table.tr class="flex items-center px-1">
                        <x-table.th class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                            <x-index.bulkaction.all/>
                        </x-table.th>

                        <x-table.th class="w-2/12">
                            <x-slot name="first">
                                <x-sortablelink column="date" title="{{ trans('receipt::general.status.date') }}"/>
                            </x-slot>
                        </x-table.th>
                        <x-table.th class="w-2/12">
                            <x-slot name="first">
                                <x-sortablelink column="merchant"
                                                title="{{  trans('receipt::general.status.merchant') }}"/>
                            </x-slot>
                        </x-table.th>

                        <x-table.th class="w-2/12 sm:table-cell">
                            <x-sortablelink column="total_amount"
                                            title="{{ trans('receipt::general.status.total_amount') }}"/>
                        </x-table.th>

                        <x-table.th class="w-2/12 sm:table-cell">
                            <x-sortablelink column="tax_amount"
                                            title="{{ trans('receipt::general.status.tax_amount') }}"/>
                        </x-table.th>

                        <x-table.th class="w-2/12">
                            <x-sortablelink column="contact.name" title="{{ trans_choice('general.vendors', 1) }}"/>
                        </x-table.th>
                        <x-table.th class="w-2/12">
                            <x-sortablelink column="statuses" title="{{ trans_choice('general.statuses',2)}}"/>
                        </x-table.th>
                    </x-table.tr>
                </x-table.thead>

                <x-table.tbody>
                    @foreach($receipts as $receipt)
                        <x-table.tr href="{{ route('receipt.edit', $receipt->id) }}">
                            <x-table.td class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                <x-index.bulkaction.single id="{{ $receipt->id }}" name="{{ $receipt->merchand }}"/>
                            </x-table.td>

                            <x-table.td class="w-2/12 truncate">
                                <x-date date="{{ $receipt->date }}"/>
                            </x-table.td>

                            <x-table.td class="w-2/12 truncate">
                                {{ $receipt->merchant }}
                            </x-table.td>

                            <x-table.td class="w-2/12 truncate">
                                <x-money :amount="$receipt->total_amount" :currency="$receipt->currency_code" convert />
                            </x-table.td>

                            <x-table.td class="w-2/12 truncate">
                                <x-money :amount="$receipt->tax_amount" :currency="$receipt->currency_code" convert />
                            </x-table.td>

                            <x-table.td class="w-2/12 truncate">
                                <div class="w-32">
                                    {{ $receipt->contact->name }}
                                </div>
                            </x-table.td>

                            <x-table.td class="w-2/12 truncate">
                                @if ($receipt->statuses == "Approved")
                                    <x-index.status status="{{ mb_strtolower($receipt->statuses) }}"
                                                    background-color="bg-status-success"
                                                    text-color="text-text-success"/>

                                @elseif ($receipt->statuses == "Draft")
                                    <x-index.status status="{{ mb_strtolower($receipt->statuses) }}"
                                                    background-color="bg-status-draft"
                                                    text-color="text-text-draft"/>
                                @endif
                            </x-table.td>

                            <x-table.td kind="action">
                                <x-table.actions :model="$receipt"/>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.tbody>
            </x-table>

            <x-pagination :items="$receipts"/>
        </x-index.container>
    </x-slot>

    <x-script alias="receipt" file="receipts"/>
</x-layouts.admin>
