<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.edit', ['type' => trans_choice('sales-purchase-orders::general.sales_orders', 1)]) }}
    </x-slot>

    <x-slot name="content">
        <x-documents.form.content
            :type="$type"
            :document="$salesOrder"
            contact-type="customer"
            hide-recurring
            hide-due-at
            :text-item-description="@trans('general.description')"
        />
    </x-slot>

    <x-documents.script :type="$type" :items="$salesOrder->items()->get()" :document="$salesOrder" alias="core" />
</x-layouts.admin>
