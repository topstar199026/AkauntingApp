<x-form.group.select
    name="bill_id"
    label="{{ trans_choice('general.bills', 1) }}"
    icon="file-invoice-dollar"
    :options="$bills"
    :selected="$bill_id"
    dynamicOptions="bills"
    not-required
    form-group-class="sm:col-span-2"
/>
