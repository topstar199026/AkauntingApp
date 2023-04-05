<x-layouts.admin>
    <x-slot name="title">{{ trans_choice('receipt::general.title', 2) }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="receipt" method="PATCH" :route="['receipt.update', $receipt->id]" :model="$receipt">
                <x-form.section>
                    <x-slot name="body">
                        <div class="sm:col-span-3 grid gap-x-8 gap-y-6 sm:grid-cols-3">
                            <x-form.input.hidden name="currency_code" :value="$currency->code" />
                            <x-form.input.hidden name="currency_rate" value="1" />

                            <x-form.group.date name="date" label="{{ trans('general.date') }}" icon="calendar_today" value="{{ request()->get('date', Date::now()->toDateString()) }}" show-date-format="{{ company_date_format() }}" date-format="Y-m-d" autocomplete="off" value="{{$receipt->date}}"/>

                            <x-form.group.text name="merchant" label="{{ trans('receipt::general.status.merchant') }}"  value="{{$receipt->merchant}}" class="col-span-6" />

                            <x-form.group.money name="total_amount" label="{{ trans('receipt::general.status.total_amount') }}" value="{{ $receipt->total_amount }}" autofocus="autofocus" :currency="$currency" dynamicCurrency="currency"/>

                            <x-form.group.money name="tax_amount" label="{{ trans('receipt::general.status.tax_amount') }}" value="{{ $receipt->tax_amount }}" autofocus="autofocus" :currency="$currency" dynamicCurrency="currency" />

                            <x-form.group.contact name="contact_id" type="{{ config('type.transaction.expense.contact_type') }}" not-required />

                            <x-form.group.category type="{{ $type }}" :selected="setting('default.' . $type . '_category')" />

                            <x-form.group.payment-method/>
                        </div>

                        <div class="sm:col-span-3 grid gap-x-8 gap-y-6">
                            @if ($mime_type == 'application/pdf')
                                <embed src="data:application/pdf;base64,{{ $receipt->image }}" height="500px"
                                       width="400x"/>
                            @else
                                <img src="data:image/png;base64,{{ $receipt->image }}" height="500px"
                                     width="400x"/>
                            @endif
                        </div>

                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="receipt.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="receipt" file="receipts"/>
</x-layouts.admin>
