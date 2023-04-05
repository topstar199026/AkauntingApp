@php
foreach ($class->footer_totals as $table => $dates) {
    foreach ($dates as $date => $totals) {
        if (!isset($class->net_profit[$date])) {
            $class->net_profit[$date]['budgeted'] = 0;
            $class->net_profit[$date]['actual'] = 0;
            $class->net_profit[$date]['over_budget'] = 0;
        }

        $class->net_profit[$date]['budgeted'] += $totals['budgeted'] * ($table === 'income' ? 1 : -1);
        $class->net_profit[$date]['actual'] += $totals['actual'] * ($table === 'income' ? 1 : -1);
        $class->net_profit[$date]['over_budget'] += $totals['over_budget'] * ($table === 'income' ? 1 : -1);
    }

    foreach($class->net_profit as $date => $profit) {
        $class->net_profit[$date]['over_budget_percentage'] = \Modules\Budgets\Support\BudgetSupport::calculateOverBudgetPercentage($profit['actual'], $profit['budgeted']);
        $class->net_profit[$date]['over_budget_style'] = $profit['over_budget'] > 0 ? 'text-green-500' : 'text-red-500';
    }
}
@endphp

<tfoot>
    <tr class="hover:bg-gray-100 px-1 group transition-[height]">
        <th class="text-left px-6 py-4 border whitespace-nowrap truncate">{{ trans('budgets::general.net_profit') }}</th>
        @foreach($class->net_profit as $date => $profit)
            <th class="p-0 border budget-row">
                @include('budgets::budget_vs_actual.detail.table.row', [
                    'row' => $profit, 'total' => true
                ])
            </th>
        @endforeach
    </tr>
</tfoot>
