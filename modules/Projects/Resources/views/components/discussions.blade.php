@if($discussions->isNotEmpty())
    <x-table>
        <x-table.thead>
            <x-table.tr>
                <x-table.th class="w-4/12">
                    <x-sortablelink column="subject" title="{{ trans('general.subject') }}" />
                </x-table.th>

                <x-table.th class="w-3/12">
                    <x-sortablelink column="created_by" title="{{ trans('projects::general.created_by') }}" />
                </x-table.th>

                <x-table.th class="w-3/12">
                    <x-sortablelink column="comment" title="{{ trans_choice('projects::general.comments', 2) }}" />
                </x-table.th>

                <x-table.th class="w-2/12" kind="right">
                    <x-sortablelink column="like" title="{{ trans_choice('projects::general.likes', 2) }}" />
                </x-table.th>
            </x-table.tr>
        </x-table.thead>

        <x-table.tbody>
            @foreach($discussions as $item)
                <x-table.tr>

                    <x-table.td class="w-4/12">
                        {{ $item->subject }}
                    </x-table.td>

                    <x-table.td class="w-3/12">
                        {{ $item->user->name }}
                    </x-table.td>

                    <x-table.td class="w-3/12">
                        {{ $item->comments->count() }}
                    </x-table.td>

                    <x-table.td class="w-2/12" kind="right">
                        {{ $item->likes->count() }}
                    </x-table.td>

                    <x-table.td kind="action">
                        <x-table.actions :model="$item" />
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>

    <x-pagination :items="$discussions" />
    @else
    <x-projects::show.no-records name="discussions" :project="$project" />
@endif
