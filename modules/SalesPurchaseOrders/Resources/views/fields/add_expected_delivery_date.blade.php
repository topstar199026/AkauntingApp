<x-form.group.date
    name="expected_delivery_date"
    label="{{ trans('sales-purchase-orders::purchase_orders.expected_delivery_date') }}"
    icon="calendar_today"
    value="{{ $expected_delivery_date }}"
    show-date-format="{{ company_date_format() }}"
    date-format="Y-m-d"
    autocomplete="off"
    period="{{ setting('purchase_order.delivery_terms') }}"
    min-date="form.issued_at"
    min-date-dynamic="min_due_date"
    data-value-min
    form-group-class="sm:col-span-2"
/>
