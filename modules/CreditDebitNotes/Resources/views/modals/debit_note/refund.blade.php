<x-form
    id="form-refund-transaction"
    :route="$route"
>
    <base-alert type="warning" v-if="typeof form.response !== 'undefined' && form.response.error" v-html="form.response.message"></base-alert>

    <div class="grid sm:grid-cols-6 gap-x-8 gap-y-6 my-3.5">
        <x-form.group.date name="paid_at" label="{{ trans('general.date') }}" icon="calendar_today" value="{{ Date::now()->toDateString() }}" show-date-format="{{ company_date_format() }}" date-format="Y-m-d" autocomplete="off" />

        <x-form.group.money name="amount" label="{{ trans('general.amount') }}" value="{{ $debit_note->amount }}" autofocus="autofocus" :currency="$currency" dynamicCurrency="currency" />

        <x-form.group.account change="onChangePaymentAccount" />

        <x-form.group.text name="currency" label="{{ trans_choice('general.currencies', 1) }}" value="{{ $debit_note->currency->name }}" not-required disabled />

        <x-form.group.textarea name="description" label="{{ trans('general.description') }}" rows="3" not-required />

        <x-form.group.payment-method />

        <x-form.group.category type="income" />

        <x-form.input.hidden name="document_id" :value="$debit_note->id" />
        <x-form.input.hidden name="amount" :value="$debit_note->amount" />
        <x-form.input.hidden name="currency_code" :value="$debit_note->currency_code" />
        <x-form.input.hidden name="currency_rate" :value="$debit_note->currency_rate" />
        <x-form.input.hidden name="number" :value="$number" />
        <x-form.input.hidden name="type" value="income" />
        {{--TODO: check if it is possible to use custom transaction types--}}
        {{--        <x-form.input.hidden name="type" value="debit_note_refund" />--}}
    </div>
</x-form>
