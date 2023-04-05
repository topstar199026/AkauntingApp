<x-form.group.radio
    name="credit_customer_account"
    label="{{ trans('credit-debit-notes::credit_notes.credit_customer_account') }}"
    :options="[
        '1' => trans('general.yes'),
        '0' => trans('general.no'),
    ]"
    :checked="$credit_customer_account ? '1' : '0'"
    not-required
    form-group-class="sm:col-span-2"
/>
