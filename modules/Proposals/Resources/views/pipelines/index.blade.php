<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('proposals::general.pipelines', 2) }}
    </x-slot>

    <x-slot name="content">
        @if ($pipelines->count())
            <x-index.container>
                <x-index.search search-string="Modules\Proposals\Models\ProposalPipeline" />

                <x-table>
                    <x-table.thead>
                        <x-table.tr>
                            <x-table.th class="w-6/12 sm:w-3/12">
                                {{ trans('general.name') }}
                            </x-table.th>

                            <x-table.th class="w-6/12 sm:w-3/12">
                                {{ trans('proposals::general.create') }}
                            </x-table.th>

                            <x-table.th class="w-2/12" hidden-mobile>
                                {{ trans('proposals::general.send') }}
                            </x-table.th>

                            <x-table.th class="w-2/12" hidden-mobile>
                                {{ trans('proposals::general.approve') }}
                            </x-table.th>

                            <x-table.th class="w-2/12" hidden-mobile>
                                {{ trans('proposals::general.refuse') }}
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach($pipelines as $item)
                            <x-table.tr href="{{ route('proposals.pipelines.edit', $item->id) }}">
                                <x-table.td class="w-6/12 sm:w-3/12">
                                    {{ $item->pipeline ? $item->pipeline->name : '' }}
                                </x-table.td>

                                <x-table.td class="w-6/12 sm:w-3/12">
                                    {{ $item->pipeline && $item->stage_id_create != null ? $item->pipeline->stages->where('id', $item->stage_id_create)->first()->name : '-' }}
                                </x-table.td>

                                <x-table.td class="w-2/12" hidden-mobile>
                                    {{ $item->pipeline && $item->stage_id_send != null ? $item->pipeline->stages->where('id', $item->stage_id_send)->first()->name : '-' }}
                                </x-table.td>

                                <x-table.td class="w-2/12" hidden-mobile>
                                    {{ $item->pipeline && $item->stage_id_approve != null ? $item->pipeline->stages->where('id', $item->stage_id_approve)->first()->name : '-' }}
                                </x-table.td>

                                <x-table.td class="w-2/12" hidden-mobile>
                                    {{ $item->pipeline && $item->stage_id_refused != null ? $item->pipeline->stages->where('id', $item->stage_id_refused)->first()->name : '-' }}
                                </x-table.td>

                                <x-table.td kind="action">
                                    <x-table.actions :model="$item" />
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.tbody>
                </x-table>

                <x-pagination :items="$pipelines" />
            </x-index.container>
        @else
            <x-empty-page group="proposals" page="pipelines" />
        @endif
    </x-slot>

    <x-script alias="proposals" file="pipelines" />
</x-layouts.admin>