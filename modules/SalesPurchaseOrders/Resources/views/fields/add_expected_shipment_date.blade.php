<x-form.group.date
    name="expected_shipment_date"
    label="{{ trans('sales-purchase-orders::sales_orders.expected_shipment_date') }}"
    icon="calendar_today"
    value="{{ $expected_shipment_date }}"
    show-date-format="{{ company_date_format() }}"
    date-format="Y-m-d"
    autocomplete="off"
    period="{{ setting('sales_order.shipment_terms') }}"
    min-date="form.issued_at"
    min-date-dynamic="min_due_date"
    data-value-min
    form-group-class="sm:col-span-2"
/>
