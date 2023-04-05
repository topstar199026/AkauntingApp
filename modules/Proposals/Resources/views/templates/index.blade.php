<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('general.templates', 2) }}
    </x-slot>

    <x-slot name="buttons">
        @permission('create-proposals-templates')
            <x-link href="{{ route('proposals.templates.create') }}" kind="primary">
                {{ trans('general.add_new') }}
            </x-link>
        @endpermission
    </x-slot>

    <x-slot name="content">
    @if ($templates->count())
        <x-index.container>
            <x-index.search
                search-string="Modules\Proposals\Models\Template"
                bulk-action="Modules\Proposals\BulkActions\Templates"
            />

            <x-table>
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th kind="bulkaction">
                            <x-index.bulkaction.all />
                        </x-table.th>

                        <x-table.th class="w-4/12">
                            {{ trans('general.name') }}
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
                @foreach($templates as $item)
                    <x-table.tr href="{{ route('proposals.templates.edit', $item->id) }}">
                        <x-table.td kind="bulkaction">
                            <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->id }}" />
                        </x-table.td>

                        <x-table.td class="w-4/12">
                            {{ $item->name }}
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

            <x-pagination :items="$templates" />
        </x-index.container>
    @else
        <x-empty-page group="proposals" page="templates" />
    @endif
    </x-slot>

    <x-script alias="proposals" file="templates" />
</x-layouts.admin>
