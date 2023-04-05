<tbody>
    @include($class->views['detail.table.header'])

    @if (!empty($class->row_values[$table]))
        @foreach($class->row_values[$table] as $id => $rows)
            @include($class->views['detail.table.rows'])
        @endforeach
        <tr class="hover:bg-gray-100 px-1 group transition-[height]">
            <th class="text-left px-6 py-4 border whitespace-nowrap truncate">
                {{ trans_choice('general.totals', 1) }}
            </th>
            @foreach($class->footer_totals[strtolower($table)] as $date => $totals)
                <td class="p-0 border budget-row">
                    @include('budgets::budget_vs_actual.detail.table.row', [
                        'row' => $totals, 'total' => true
                    ])
                </td>
            @endforeach
        </tr>
    @else
        <tr>
            <td colspan="{{ count($class->dates) + 2 }}">
                <div class="pl-0 text-muted">{{ trans('general.no_records') }}</div>
            </td>
        </tr>
    @endif
</tbody>
@include($class->views['detail.table.footer'])
