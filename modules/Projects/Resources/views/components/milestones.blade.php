@if($milestones->isNotEmpty())
    <x-table>
        <x-table.thead>
            <x-table.tr>
                <x-table.th class="w-4/12">
                    <x-sortablelink column="deadline_at" :title="trans('general.end_date')" />
                </x-table.th>

                <x-table.th class="w-4/12">
                    <x-sortablelink column="name" title="{{ trans('general.name') }}" />
                </x-table.th>

                <x-table.th class="w-4/12" kind="right">
                    <x-sortablelink column="description" :title="trans('general.description')" />
                </x-table.th>
            </x-table.tr>
        </x-table.thead>

        <x-table.tbody>
            @foreach($milestones as $item)
                <x-table.tr>
                    <x-table.td class="w-4/12">
                        <x-date :date="$item->deadline_at" />
                    </x-table.td>

                    <x-table.td class="w-4/12">
                        {{ $item->name }}
                    </x-table.td>

                    <x-table.td class="w-4/12" kind="right">
                        {{ $item->description }}
                    </x-table.td>

                    <x-table.td kind="action">
                        <x-table.actions :model="$item" />
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>

    <x-pagination :items="$milestones" />
    @else
    <x-projects::show.no-records name="milestones" :project="$project" />
@endif