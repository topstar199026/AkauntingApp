<x-tabs.tab id="credit-notes">
    @if ($credit_notes->count())
        <x-table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th class="w-4/12 lg:w-3/12">
                        <x-slot name="first">
                            <x-sortablelink column="issued_at" title="{{ trans('credit-debit-notes::credit_notes.credit_note_date') }}" />
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
                @foreach($credit_notes as $item)
                    <x-table.tr href="{{ route('credit-debit-notes.credit-notes.show', $item->id) }}">
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
                            @if($item->invoice)
                                <x-slot name="first" class="font-bold truncate" override="class">
                                    <x-date date="{{ $item->invoice->issued_at }}" />
                                </x-slot>

                                <x-slot name="second" class="w-20 font-normal group" data-tooltip-target="tooltip-information-{{ $item->invoice->id }}" data-tooltip-placement="right" override="class,data-tooltip-target,data-tooltip-placement">
                                <span class="border-black border-b border-dashed">
                                    <x-link href="{{ route('invoices.show', $item->invoice->id) }}" class="border-b" override="class">
                                        {{ $item->invoice->document_number }}
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

        <x-pagination :items="$credit_notes" />
    @else
        <x-show.no-records
            type="{{ $type }}"
            description="{{ trans('credit-debit-notes::customers.no_records.credit_notes') }}"
            textAction="{{ trans('general.title.new', ['type' => trans_choice('credit-debit-notes::general.credit_notes', 1)]) }}"
            url="{{ route('credit-debit-notes.customers.create-credit-note', $contact->id) }}"
            :model="$contact"
            group="credit-debit-notes"
            page="credit_notes"
            image="public/img/no_records/customers_invoices.png"
        />
    @endif
</x-tabs.tab>
