<table class="text-center w-full budget-table">
    <tr class="border-top-style font-size-unset">
        <td class="{{ $total ? 'font-semibold' : '' }}">
            @money($row['budgeted'], setting('default.currency'), true)
        </td>
        <td class="{{ $total ? 'font-semibold' : '' }}">
            @money($row['actual'], setting('default.currency'), true)
            @if (isset($row['actual_percentage']) && $row['actual_percentage'])
                <br /><span class="text-muted">({{ number_format($row['actual_percentage'], 2) }}%)</span>
            @endif
        </td>
            <td class="{{ $total ? 'font-semibold' : '' }}">
            @money($row['over_budget'], setting('default.currency'), true)
            @if (isset($row['over_budget_percentage']) && $row['over_budget_percentage'])
                <br /><span class="{{ $row['over_budget_style'] }}">({{ number_format($row['over_budget_percentage'], 2) }}%)</span>
            @endif
        </td>
    </tr>
</table>
