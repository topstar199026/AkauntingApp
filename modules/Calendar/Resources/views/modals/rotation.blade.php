<div class="grid grid-cols-2 py-1 px-5 bg-body flex flex-col justify-center">
    <div class="group relative pb-2.5 pl-2.5">
        <button class="flex items-center" @click="onAction('invoice', '{{ route('invoices.create') }}')">
            <div class="w-8 h-8 flex items-center justify-center">
                <x-icon icon="description"></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans_choice('general.invoices', 1) }}</span>
        </button>
    </div>

    <div class="group relative pb-2.5 pl-2.5">
        <button class="flex items-center" @click="onAction('income', '{{ route('transactions.create') }}')">
            <div class="w-8 h-8 flex items-center justify-center">
                <x-icon icon="receipt_long"></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans_choice('general.incomes', 1) }}</span>
        </button>
    </div>

    <div class="group relative pb-2.5 pl-2.5">
        <button class="flex items-center" @click="onAction('bill', '{{ route('bills.create') }}')">
            <div class="w-8 h-8 flex items-center justify-center">
                <x-icon icon="shopping_cart"></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans_choice('general.bills', 1) }}</span>
        </button>
    </div>

    <div class="group relative pb-2.5 pl-2.5">
        <button class="flex items-center" @click="onAction('expense', '{{ route('transactions.create') }}')">
            <div class="w-8 h-8 flex items-center justify-center">
                <x-icon icon="receipt"></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans_choice('general.expenses', 1) }}</span>
        </button>
    </div>
</div>
