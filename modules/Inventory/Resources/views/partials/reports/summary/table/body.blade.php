<div>
    <div class="flex items-center justify-between text-xl text-black-400 border-b pb-2">
        <h2>{{ $table_name }}</h2>
    </div>
    @if (!empty($class->row_values[$table_key]))
        <ul class="space-y-2 my-3">
            @foreach($class->row_tree_nodes[$table_key] as $id => $node)
                @include($class->views['summary.table.row'])
            @endforeach
        </ul>
    @else
        <tr>
            <td colspan="{{ count($class->dates) + 2 }}">
                <div class="text-muted pl-0">{{ trans('general.no_records') }}</div>
            </td>
        </tr>
    @endif
</div>
