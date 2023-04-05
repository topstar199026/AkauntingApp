<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('sales-purchase-orders::general.purchase_orders', 2) }}
    </x-slot>

    <x-slot name="favorite"
            title="{{ trans_choice('sales-purchase-orders::general.purchase_orders', 2) }}"
            icon="request_quote"
            route="sales-purchase-orders.purchase-orders.index"
    ></x-slot>

    <x-slot name="buttons">
        <x-documents.index.buttons :type="$type" />
    </x-slot>

    <x-slot name="moreButtons">
        <x-documents.index.more-buttons :type="$type" />
    </x-slot>

    <x-slot name="content">
        <x-documents.index.content
            page="purchase_orders"
            :type="$type"
            :documents="$purchaseOrders"
            :active-tab="$type"
            without-tabs
            hide-due-at
            hide-recurring-templates
        />
    </x-slot>

    <x-documents.script :type="$type" alias="core" />
</x-layouts.admin>
