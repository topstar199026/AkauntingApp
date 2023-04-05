<x-layouts.admin>
    <x-slot name="title">{{ trans_choice('appointments::general.questions', 1) }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans_choice('appointments::general.questions', 1) }}"
        icon="today"
        route="appointments.questions.index"
    ></x-slot>

    <x-slot name="buttons">
        @can('create-appointments-questions')
            <x-link href="{{ route('appointments.questions.create') }}" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('appointments::general.questions', 1)]) }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="content">
        @if ($questions->count() || request()->get('search', false))
            <x-index.container>
                <x-index.search
                    search-string="Modules\Appointments\Models\Question"
                    bulk-action="Modules\Appointments\BulkActions\Questions"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr class="flex items-center px-1">
                            <x-table.th class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                <x-index.bulkaction.all />
                            </x-table.th>

                            <x-table.th class="w-6/12">
                                {{ trans_choice('appointments::general.questions', 1) }}
                            </x-table.th>

                            <x-table.th class="w-3/12 hidden sm:table-cell">
                                {{ trans('appointments::general.question_types') }}
                            </x-table.th>

                            <x-table.th class="w-3/12 hidden sm:table-cell">
                                {{ trans('appointments::general.required_answer') }}
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach($questions as $item)                           
                            <x-table.tr href="{{ route('appointments.questions.edit', $item->id) }}" data-table-list class="relative flex items-center border-b hover:bg-gray-100 px-1 group">
                                <x-table.td class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                    <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->question }}" />
                                </x-table.td>

                                <x-table.td class="w-6/12">
                                    <div class="truncate">
                                        {{ $item->question }}
                                    </div>

                                    @if (! $item->enabled)
                                        <x-index.disable text="{{ trans_choice('appointments::general.questions', 1) }}" />
                                    @endif
                                </x-table.td>

                                <x-table.td class="w-3/12 truncate hidden sm:table-cell">
                                    {{ $item->question_type }}
                                </x-table.td>

                                <x-table.td class="w-3/12 hidden sm:table-cell">
                                    @if ($item->required_answer == 1)
                                        {{ trans('appointments::general.required') }}
                                    @else
                                        {{ trans('appointments::general.not_required') }}
                                    @endif
                                </x-table.td>

                                <x-table.td class="p-0" override="class">
                                    <x-table.actions :model="$item" />
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.tbody>
                </x-table>

                <x-pagination :items="$questions" />
            </x-index.container>
        @else
            <x-empty-page group="appointments" page="questions" hide-button-import />
        @endif
    </x-slot>

    <x-script alias="appointments" file="questions" />
</x-layouts.admin>