<x-layouts.portal>
    <x-slot name="title">
        {{ trans_choice('proposals::general.proposals', 2) }}
    </x-slot>

    <x-slot name="content">
        <x-index.container>
            <x-table>
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th class="w-4/12">
                            {{ trans_choice('estimates::general.estimates', 1) }}
                        </x-table.th>

                        <x-table.th class="w-4/12">
                            {{ trans_choice('general.description', 1) }}
                        </x-table.th>

                        <x-table.th class="w-4/12">
                            {{ trans_choice('proposals::general.content', 1) }}
                        </x-table.th>
                    </x-table.tr>
                </x-table.thead>

                <x-table.tbody>
                    @foreach($proposals as $item)
                        <x-table.tr href="{{ route('portal.proposals.proposals.show', $item->id) }}">
                            <x-table.td class="w-4/12">
                                {{ $item->estimate->document_number }}
                            </x-table.td>

                            <x-table.td class="w-4/12">
                                {{ $item->description }}
                            </x-table.td>

                            <x-table.td class="w-4/12">
                                {{ substr(htmlspecialchars(trim(strip_tags($item->content_html))), 0, 150) }}
                            </x-table.td>

                            <x-table.td kind="action">
                                <x-table.actions :model="$item" />
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.tbody>
            </x-table>

            <x-pagination :items="$proposals" />
        </x-index.container>
    </x-slot>

    <x-script folder="portal" file="proposals" />
</x-layouts.admin>
