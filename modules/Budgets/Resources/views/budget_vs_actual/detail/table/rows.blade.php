<tr class="hover:bg-gray-100 px-1 group transition-[height]">
    <td class="text-left px-6 py-4 border whitespace-nowrap truncate" title="{{ $class->row_names[$table][$id] }}">{{ $class->row_names[$table][$id] }}</td>
    @foreach($rows as $row)
        <td class="p-0 border budget-row">
            @include('budgets::budget_vs_actual.detail.table.row', [
                'row' => $row, 'total' => false
            ])
        </td>
    @endforeach
</tr>
