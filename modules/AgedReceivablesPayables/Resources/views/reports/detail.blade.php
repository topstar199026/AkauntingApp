<div class="text-xl">
    {{ trans('aged-receivables-payables::general.as-of-show', ['date' => company_date($class->asAt)]) }}
</div>

<table class="w-full rp-border-collapse">
    <thead>
        <tr>
            <th class="w-1/7 py-1 print-alignment">&nbsp;</th>
            @if($class->includeUpcoming)
                <th class="w-1/7 py-1 ltr:text-right rtl:text-left text-purple font-medium text-xs uppercase print-alignment">
                    {{ __('aged-receivables-payables::general.upcoming') }}
                </th>
            @endif
            @foreach($class->periods as $period)
                <th class="w-1/7 py-1 ltr:text-right rtl:text-left text-purple font-medium text-xs uppercase print-alignment">
                    {{ $period['name'] }}
                </th>
            @endforeach
            <th class="w-1/7 py-1 ltr:text-right rtl:text-left text-purple font-medium text-xs uppercase print-alignment">
                {{ trans_choice('general.totals', 1) }}
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($class->rows as $row)
            <tr>
                <td class="w-1/7 py-1 text-left text-black-400">
                    {{ $row['key'] }}
                </td>
                @if($class->includeUpcoming)
                    <td class="w-1/7 py-1 text-right text-black-400 text-xs">
                        {{ money($row['upcoming'] * 100) }}
                    </td>
                @endif
                @foreach($class->periods as $period)
                    <td class="w-1/7 py-1 text-right text-black-400 text-xs">
                        {{ money($row[$period['slug']] * 100) }}
                    </td>
                @endforeach
                <td class="w-1/7 py-1 text-right text-black-400 text-xs">
                    {{ money($row['total'] * 100) }}
                </td>
            </tr>
        @endforeach
    </tbody>
    @empty($class->footer_totals)
        <tr>
            <td class="p-2 text-center bg-red-100" colspan="{{ $class->includeUpcoming ? 7 : 6 }}">
                {{ __('aged-receivables-payables::general.no-aged-'.$class->aged_type) }}
            </td>
        </tr>
    @else
        <tfoot>
            <tr class="font-bold uppercase">
                <td class="w-1/7 py-1 text-left text-black-400 text-sm">
                    {{ trans_choice('general.totals', 1) }}
                </td>
                @if($class->includeUpcoming)
                    <td class="w-1/7 py-1 text-right text-black-400 text-xs">
                        {{ money($class->footer_totals['upcoming'] * 100) }}
                    </td>
                @endif
                @foreach($class->periods as $period)
                    <td class="w-1/7 py-1 text-right text-black-400 text-xs">
                        {{ money($class->footer_totals[$period['slug']] * 100) }}
                    </td>
                @endforeach
                <td class="w-1/7 py-1 text-right text-black-400 text-xs">
                    {{ money($class->footer_totals['total'] * 100) }}
                </td>
            </tr>
        </tfoot>
    @endempty
</table>
