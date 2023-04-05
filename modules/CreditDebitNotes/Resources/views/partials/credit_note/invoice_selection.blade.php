<x-form.group.select
    name="invoice_id"
    label="{{ trans_choice('general.invoices', 1) }}"
    icon="file-invoice-dollar"
    :options="$invoices"
    :selected="$invoice_id"
    dynamicOptions="invoices"
    not-required
    form-group-class="sm:col-span-2"
/>
