<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.edit', ['type' => trans_choice('sales-purchase-orders::general.purchase_orders', 1)]) }}
    </x-slot>

    <x-slot name="content">
        <x-documents.form.content
            :type="$type"
            :document="$purchaseOrder"
            contact-type="vendor"
            hide-recurring
            hide-due-at
            :text-item-description="@trans('general.description')"
        />
    </x-slot>

    <x-documents.script :type="$type" :items="$purchaseOrder->items()->get()" :document="$purchaseOrder" alias="core" />
</x-layouts.admin>
