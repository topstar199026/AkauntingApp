<div class="text-xl">
    {{ trans('time-to-get-paid::general.as-of-show', ['date' => company_date($class->asAt)]) }}

</div>

<table class="w-full rp-border-collapse">
    <thead>
    <tr>
        <th class="w-1/7 py-1 ltr:text-left rtl:text-left text-purple font-medium text-xs uppercase print-alignment">{{__('general.name')}}</th>
        @foreach($class->dates as $date)
            <th class="w-1/7 py-1 ltr:text-right rtl:text-left text-purple font-medium text-xs uppercase print-alignment">
                {{ ($date) }}
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($class->rows as $row)
        <tr>
        <tr>
            <td class="w-1/7 py-1 text-left text-black-400 text-xs">
            {{ $row['key'] }}
            </td>
            @foreach($class->periods as $period)
                <td class="w-1/7 py-1 text-right text-black-400 text-xs">
                    {{ $row[$period['slug']] }}%
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
