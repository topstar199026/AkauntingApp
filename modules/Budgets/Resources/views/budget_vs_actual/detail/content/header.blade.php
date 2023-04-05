<thead>
    <tr>
        <th class="text-center col-sm-4 border-top-0 budget-heading" rowspan="2"></th>
        @foreach($class->dates as $date)
            <th class="px-6 py-4 whitespace-nowrap truncate">{{ $date }}</th>
        @endforeach
    </tr>
    <tr>
        @foreach($class->dates as $date)
            <th class="p-0 border budget-row">
                <table class="w-full">
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap truncate">{{ trans('budgets::general.amounts.budget') }}</th>
                        <th class="px-6 py-4 whitespace-nowrap truncate">{{ trans('budgets::general.amounts.actual') }}</th>
                        <th class="px-6 py-4 whitespace-nowrap truncate">{{ trans('budgets::general.amounts.over_budget') }}</th>
                    </tr>
                </table>
            </th>
        @endforeach
    </tr>
</thead>
