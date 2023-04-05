<div class="w-full overflow-auto mt-4 text-sm">
    <table class="w-full fixed-header budget-table rp-border-collapse">
        @include($class->views['detail.content.header'])

        @foreach($class->tables as $table)
            @include($class->views['detail.table'])
        @endforeach

        @include($class->views['detail.content.footer'])
    </table>
</div>

@push('css')
    <style>
        .budget-table th,
        .budget-table td {
            /* height: 64px !important; */
        }
        .budget-table .budget-heading {
            min-width: 300px;
        }
        .budget-table .budget-row {
            min-width: 360px;
        }
        .budget-table .budget-row th,
        .budget-table .budget-row td,
        .budget-table .budget-row table th,
        .budget-table .budget-row table td {
            min-width: 120px;
        }
    </style>
@endpush
