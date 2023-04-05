<x-show.accordion type="convert" :open="true">
    <x-slot name="head">
        <x-show.accordion.head
            title="{{ trans('sales-purchase-orders::general.convert') }}"
            description="{{ $description }}"
        />
    </x-slot>

    <x-slot name="body">
        <div class="flex flex-wrap space-x-3 rtl:space-x-reverse">
            @can('update-sales-purchase-orders-sales-orders')
                <x-link override="class" class="px-3 py-1.5 mb-3 sm:mb-0 rounded-xl text-sm font-medium leading-6 bg-green hover:bg-green-700 text-white disabled:bg-green-100"
                        href="{{ route('sales-purchase-orders.sales-orders.convert-to-invoice', $document->id) }}"
                        @click="e => e.target.classList.add('disabled')"
                >
                    {{ trans('sales-purchase-orders::sales_orders.convert_to_invoice') }}
                </x-link>
                <x-link override="class" class="px-3 py-1.5 mb-3 sm:mb-0 rounded-xl text-sm font-medium leading-6 bg-white hover:bg-white-700 disabled:bg-white-100"
                        href="{{ route('sales-purchase-orders.sales-orders.convert-to-purchase-order', $document->id) }}"
                        @click="e => e.target.classList.add('disabled')"
                >
                    {{ trans('sales-purchase-orders::sales_orders.convert_to_purchase_order') }}
                </x-link>
            @endcan
        </div>
    </x-slot>
</x-show.accordion>
