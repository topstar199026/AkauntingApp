<x-tabs.tab id="debit-notes">
    @if ($debit_notes->count())
        <x-table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th class="w-4/12 lg:w-3/12">
                        <x-slot name="first">
                            <x-sortablelink column="issued_at" title="{{ trans('credit-debit-notes::debit_notes.debit_note_date') }}" />
                        </x-slot>

                        <x-slot name="second">
                            <x-sortablelink column="document_number" title="{{ trans_choice('general.numbers', 1) }}" />
                        </x-slot>
                    </x-table.th>

                    <x-table.th class="w-3/12" hidden-mobile>
                        <x-sortablelink column="status" title="{{ trans_choice('general.statuses', 1) }}" />
                    </x-table.th>

                    <x-table.th class="w-4/12 lg:w-3/12">
                        <x-slot name="first">
                            <x-sortablelink column="issued_at" title="{{ trans('invoices.invoice_date') }}" />
                        </x-slot>

                        <x-slot name="second">
                            <x-sortablelink column="document_number" title="{{ trans_choice('general.numbers', 1) }}" />
                        </x-slot>
                    </x-table.th>

                    <x-table.th class="w-4/12 lg:w-3/12" kind="amount">
                        <x-sortablelink column="amount" title="{{ trans('general.amount') }}" />
                    </x-table.th>
                </x-table.tr>
            </x-table.thead>

            <x-table.tbody>
                @foreach($debit_notes as $item)
                    <x-table.tr href="{{ route('credit-debit-notes.debit-notes.show', $item->id) }}">
                        <x-table.td class="w-4/12 lg:w-3/12">
                            <x-slot name="first" class="font-bold truncate" override="class">
                                <x-date date="{{ $item->issued_at }}" />
                            </x-slot>

                            <x-slot name="second" class="w-20 font-normal group" data-tooltip-target="tooltip-information-{{ $item->id }}" data-tooltip-placement="left" override="class,data-tooltip-target,data-tooltip-placement">
                                <span class="border-black border-b border-dashed">
                                    {{ $item->document_number }}
                                </span>

                                <x-documents.index.information :document="$item" />
                            </x-slot>
                        </x-table.td>

                        <x-table.td class="w-3/12" hidden-mobile>
                            <x-show.status status="{{ $item->status }}" background-color="bg-{{ $item->status_label }}" text-color="text-text-{{ $item->status_label }}" />
                        </x-table.td>

                        <x-table.td class="w-4/12 lg:w-3/12">
                            @if($item->bill)
                                <x-slot name="first" class="font-bold truncate" override="class">
                                    <x-date date="{{ $item->bill->issued_at }}" />
                                </x-slot>

                                <x-slot name="second" class="w-20 font-normal group" data-tooltip-target="tooltip-information-{{ $item->bill->id }}" data-tooltip-placement="right" override="class,data-tooltip-target,data-tooltip-placement">
                                    <span class="border-black border-b border-dashed">
                                        <x-link href="{{ route('bills.show', $item->bill->id) }}" class="border-b" override="class">
                                            {{ $item->bill->document_number }}
                                        </x-link>
                                    </span>
                                </x-slot>
                            @endif
                        </x-table.td>

                        <x-table.td class="w-4/12 lg:w-3/12" kind="amount">
                            <x-money :amount="$item->amount" :currency="$item->currency_code" convert />
                        </x-table.td>

                        <x-table.td kind="action">
                            <x-table.actions :model="$item" />
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table>

        <x-pagination :items="$debit_notes" />
    @else
        <x-show.no-records
            type="{{ $type }}"
            description="{{ trans('credit-debit-notes::vendors.no_records.debit_notes') }}"
            textAction="{{ trans('general.title.new', ['type' => trans_choice('credit-debit-notes::general.debit_notes', 1)]) }}"
            url="{{ route('credit-debit-notes.vendors.create-debit-note', $contact->id) }}"
            :model="$contact"
            group="credit-debit-notes"
            page="debit_notes"
            image="public/img/no_records/vendors_bills.png"
        />
    @endif
</x-tabs.tab>
