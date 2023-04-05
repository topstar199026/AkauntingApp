<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.new', ['type' => trans_choice('sales-purchase-orders::general.sales_orders', 1)]) }}
    </x-slot>

    <x-slot name="favorite"
            title="{{ trans('general.title.new', ['type' => trans_choice('sales-purchase-orders::general.sales_orders', 1)]) }}"
            icon="add_note"
            route="sales-purchase-orders.sales-orders.create"
    ></x-slot>

    <x-slot name="content">
        <x-documents.form.content
            :type="$type"
            contact-type="customer"
            hide-recurring
            hide-due-at
            :text-item-description="@trans('general.description')"
        />
    </x-slot>

    <x-documents.script :type="$type" alias="core" />
</x-layouts.admin>
