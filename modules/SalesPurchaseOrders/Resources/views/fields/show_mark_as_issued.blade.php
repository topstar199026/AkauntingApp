<x-show.accordion type="confirm" :open="true">
    <x-slot name="head">
        <x-show.accordion.head
            title="{{ trans('general.confirm') }}"
            description="{{ $description }}"
        />
    </x-slot>

    <x-slot name="body">
        <div class="flex flex-wrap space-x-3 rtl:space-x-reverse">
            @can('update-sales-purchase-orders-purchase-orders')
                @if($document->status === 'issued')
                    <x-link override="class" class="pointer-events-none px-3 py-1.5 mb-3 sm:mb-0 rounded-xl text-sm font-medium leading-6 bg-blue-300 hover:bg-blue-500 text-white disabled:bg-blue-100"
                            href="{{ route('sales-purchase-orders.purchase-orders.issued', $document->id) }}"
                            @click="e => e.target.classList.add('disabled')"
                    >
                        {{ trans('sales-purchase-orders::purchase_orders.mark_issued') }}
                    </x-link>
                @else
                    <x-link override="class" class="px-3 py-1.5 mb-3 sm:mb-0 rounded-xl text-sm font-medium leading-6 bg-blue-300 hover:bg-blue-500 text-white disabled:bg-blue-100"
                            href="{{ route('sales-purchase-orders.purchase-orders.issued', $document->id) }}"
                            @click="e => e.target.classList.add('disabled')"
                    >
                        {{ trans('sales-purchase-orders::purchase_orders.mark_issued') }}
                    </x-link>
                @endif
            @endcan
        </div>
    </x-slot>
</x-show.accordion>
