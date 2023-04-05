<x-layouts.print>
    <x-slot name="title">
        {{ trans_choice('sales-purchase-orders::general.purchase_orders', 1) . ': ' . $document->document_number }}
    </x-slot>

    <x-slot name="content">
        <x-documents.template.modern
            :type="$type"
            :document="$document"
            hide-due-at
        />
    </x-slot>
</x-layouts.print>
