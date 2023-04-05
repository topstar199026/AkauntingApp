<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('proposals::general.proposals', 2) }}
    </x-slot>

    <x-slot name="buttons">
        @permission('create-proposals-proposals')
            <x-link href="{{ route('proposals.proposals.create') }}" kind="primary">
                {{ trans('general.add_new') }}
            </x-link>
        @endpermission

        @permission('create-proposals-templates')
            <x-link href="{{ route('proposals.templates.index') }}">
                {{ trans_choice('general.templates', 2) }}
            </x-link>
        @endpermission

        @permission('update-proposals-pipelines')
            @if($module_crm)
                <x-link href="{{ route('proposals.pipelines.index') }}">
                    {{ trans_choice('proposals::general.pipelines', 2) }}
                </x-link>
            @endif
        @endpermission
    </x-slot>

    <x-slot name="content">
        @if ($proposals->count())
            <x-index.container>
                <x-index.search
                    search-string="Modules\Proposals\Models\Proposal"
                    bulk-action="Modules\Proposals\BulkActions\Proposals"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr>
                            <x-table.th kind="bulkaction">
                                <x-index.bulkaction.all />
                            </x-table.th>

                            @if($module_estimates)
                                <x-table.th class="w-4/12">
                                    {{ trans_choice('estimates::general.estimates', 1) }}
                                </x-table.th>

                                <x-table.th class="w-4/12">
                                    {{ trans_choice('general.description', 1) }}
                                </x-table.th>
                            @else
                                <x-table.th class="w-4/12">
                                    {{ trans_choice('general.description', 1) }}
                                </x-table.th>
                            @endif
                            <x-table.th class="w-4/12">
                                {{ trans_choice('proposals::general.content', 1) }}
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                    @foreach($proposals as $item)
                        <x-table.tr href="{{ route('proposals.proposals.edit', $item->id) }}">
                            <x-table.td kind="bulkaction">
                                <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->invoice_number }}" />
                            </x-table.td>
                            
                            @if($module_estimates)
                                <x-table.td class="w-4/12">
                                    {{ $item->estimate ? $item->estimate->document_number : '' }}
                                </x-table.td>

                                <x-table.td class="w-4/12">
                                    {{ $item->description }}
                                </x-table.td>
                            @else
                                <x-table.td class="w-4/12">
                                    {{ $item->description }}
                                </x-table.td>
                            @endif

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
        @else
            <x-empty-page group="proposals" page="proposals" />
        @endif
    </x-slot>

    <x-script alias="proposals" file="proposals" />
</x-layouts.admin>
