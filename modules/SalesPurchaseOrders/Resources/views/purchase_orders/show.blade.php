<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('sales-purchase-orders::general.purchase_orders', 1) . ': ' . $purchaseOrder->document_number }}
    </x-slot>

    <x-slot name="status">
        <x-show.status
            status="{{ $purchaseOrder->status }}"
            background-color="bg-{{ $purchaseOrder->status_label }}"
            text-color="text-text-{{ $purchaseOrder->status_label }}"
        />
    </x-slot>

    <x-slot name="buttons">
        <x-documents.show.buttons
            :type="$type"
            :document="$purchaseOrder"
        />
    </x-slot>

    <x-slot name="moreButtons">
        <x-documents.show.more-buttons
            :type="$type"
            :document="$purchaseOrder"
            hide-share
        />
    </x-slot>

    <x-slot name="content">
        <x-documents.show.content
            :type="$type"
            :document="$purchaseOrder"
            share-route="{{ route('sales-purchase-orders.modals.purchase-orders.emails.create', $purchaseOrder->id) }}"
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
