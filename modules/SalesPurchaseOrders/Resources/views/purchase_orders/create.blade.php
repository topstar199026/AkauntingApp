<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.new', ['type' => trans_choice('sales-purchase-orders::general.purchase_orders', 1)]) }}
    </x-slot>

    <x-slot name="favorite"
            title="{{ trans('general.title.new', ['type' => trans_choice('sales-purchase-orders::general.purchase_orders', 1)]) }}"
            icon="request_quote"
            route="sales-purchase-orders.purchase-orders.create"
    ></x-slot>

    <x-slot name="content">
        <x-documents.form.content
            :type="$type"
            contact-type="vendor"
            hide-recurring
            hide-due-at
            is-purchase-price
            :text-item-description="@trans('general.description')"
        />
    </x-slot>

    <x-documents.script :type="$type" alias="core" />
</x-layouts.admin>
