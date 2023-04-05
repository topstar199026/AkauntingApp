<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('sales-purchase-orders::general.sales_orders', 1) . ': ' . $salesOrder->document_number }}
    </x-slot>

    <x-slot name="status">
        <x-show.status
            status="{{ $salesOrder->status }}"
            background-color="bg-{{ $salesOrder->status_label }}"
            text-color="text-text-{{ $salesOrder->status_label }}"
        />
    </x-slot>

    <x-slot name="buttons">
        <x-documents.show.buttons
            :type="$type"
            :document="$salesOrder"
        />
    </x-slot>

    <x-slot name="moreButtons">
        <x-documents.show.more-buttons
            :type="$type"
            :document="$salesOrder"
            hide-share
        />
    </x-slot>

    <x-slot name="content">
        <x-documents.show.content
            :type="$type"
            :document="$salesOrder"
            share-route="{{ route('sales-purchase-orders.modals.sales-orders.emails.create', $salesOrder->id) }}"
            hide-receive
            hide-make-payment
            hide-schedule
            hide-children
            hide-header-due-at
            hide-due-at
            hide-button-sent
            hide-button-received
            hide-button-paid
            hide-button-share
            hide-get-paid
            hide-footer-transactions
            hide-share
        />
    </x-slot>

    @push('stylesheet')
        <link rel="stylesheet" href="{{ asset('public/css/print.css?v=' . version('short')) }}" type="text/css">
    @endpush

    <x-documents.script :type="$type" alias="core" />
</x-layouts.admin>
