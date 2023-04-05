<x-show.accordion type="get_paid" :open="($accordionActive === 'make-refund')">
    <x-slot name="head">
        <x-show.accordion.head
            title="{{ trans('credit-debit-notes::credit_notes.refund_customer') }}"
            description="{!! $description !!}"
        />
    </x-slot>

    <x-slot name="body" class="block" override="class">
        <div class="flex flex-wrap space-x-3 rtl:space-x-reverse">
            @if($amount_available)
                <x-button
                    @click="onRefund"
                    id="button-make-refund"
                    class="px-3 py-1.5 mb-3 sm:mb-0 rounded-lg text-xs font-medium leading-6 bg-green hover:bg-green-700 text-white disabled:bg-green-100"
                    override="class"
                >
                    {{ trans('credit-debit-notes::credit_notes.make_refund') }}
                </x-button>
            @endif
        </div>

        <div class="text-xs mt-4" style="margin-left: 0 !important;">
            <span class="font-medium">
                {{ trans('credit-debit-notes::credit_notes.refunds_made') }} :
            </span>

            @if ($transactions->count())
                @foreach ($transactions as $transaction)
                    <div class="my-2">
                        <span>
                            <x-date :date="$transaction->paid_at" />
                             - {!! trans('credit-debit-notes::credit_notes.refund_transaction', [
                                 'amount' => '<span class="font-medium">' . money($transaction->amount, $transaction->currency_code, true) . '</span>',
                                 'account' => '<span class="font-medium">' . $transaction->account->name . '</span>',
                             ]) !!}
                        </span>

{{--TODO: uncomment after this is fixed in the Core--}}
{{--                        <x-button--}}
{{--                            @click="onEditPayment('{{ $transaction->id }}')"--}}
{{--                            id="button-edit-payment"--}}
{{--                            class="text-purple mt-1"--}}
{{--                            override="class"--}}
{{--                        >--}}
{{--                            <span class="border-b border-transparent transition-all hover:border-purple">--}}
{{--                                {{ trans('general.title.edit', ['type' => trans_choice('general.payments', 1)]) }}--}}
{{--                            </span>--}}
{{--                        </x-button>--}}

{{--                        <span> - </span>--}}

                        @php
                            $message = trans('general.delete_confirm', [
                                'name' => '<strong>' . Date::parse($transaction->paid_at)->format(company_date_format()) . ' - ' . money($transaction->amount, $transaction->currency_code, true) . ' - ' . $transaction->account->name . '</strong>',
                                'type' => strtolower(trans_choice('general.transactions', 1))
                            ]);
                        @endphp

                        <x-delete-link
                            :model="$transaction"
                            :route="'transactions.destroy'"
                            :title="trans('general.title.delete', ['type' => trans_choice('general.payments', 1)])"
                            :message="$message"
                            :label="trans('general.title.delete', ['type' => trans_choice('general.payments', 1)])"
                            class="text-purple mt-1"
                            text-class="border-b border-transparent transition-all hover:border-purple"
                            override="class"
                        />
                    </div>
                @endforeach
            @else
                <div class="my-2">
                    <span>{{ trans('general.no_records') }}</span>
                </div>
            @endif
        </div>
    </x-slot>
</x-show.accordion>
