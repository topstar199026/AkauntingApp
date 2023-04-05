<x-layouts.admin>
    <x-slot name="title">
        {{ trans('projects::general.title') }}
    </x-slot>

    <x-slot
        name="favorite"
        :title="trans_choice('projects::general.projects', 2)"
        icon="science"
        route="projects.projects.index"
    ></x-slot>

    <x-slot name="buttons">
        @can('create-projects-projects')
            <x-link :href="route('projects.projects.create')" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('projects::general.projects', 1)]) }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="content">
        @if ($projects->count() || request()->get('search', false))
            <x-index.container>
                <x-index.search
                    search-string="Modules\Projects\Models\Project"
                    bulk-action="Modules\Projects\BulkActions\Projects"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr class="flex items-center px-1">
                            <x-table.th class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                @stack('bulk_action_all_input_start')

                                <div class="text-left">
                                    <input type="checkbox"
                                        id="table-check-all"
                                        class="rounded-sm text-purple border-gray-300 cursor-pointer disabled:bg-gray-200 focus:outline-none focus:ring-transparent"
                                        v-model="bulk_action.select_all"
                                        @click="onSelectAllBulkAction"
                                    />
                                    <label for="table-check-all"></label>
                                </div>

                                @stack('bulk_action_all_input_end')
                            </x-table.th>

                            <x-table.th class="w-4/12 sm:w-2/12">
                                <x-slot name="first">
                                    <x-sortablelink column="ended_at" :title="trans('general.end_date')" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="started_at" :title="trans('general.start_date')" />
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-4/12">
                                <x-slot name="first">
                                    <x-sortablelink column="name" :title="trans('general.name')" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="description" :title="trans('general.description')" />
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-2/12" hidden-mobile>
                                {{ trans_choice('general.statuses', 1) }}
                            </x-table.th>

                            <x-table.th class="w-4/12" kind="right">
                                <x-slot name="first">
                                    {{ trans_choice('general.contacts', 1) }}
                                </x-slot>
                                <x-slot name="second">
                                    {{ trans_choice('projects::general.members', 2)}}
                                </x-slot>
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>
                    <x-table.tbody>
                        @foreach($projects as $project)
                            <x-table.tr>
                                <x-table.td class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                    <x-index.bulkaction.single :id="$project->id" :name="$project->name" />
                                </x-table.td>

                                <x-table.td class="w-4/12 sm:w-2/12">
                                    <x-slot name="first">
                                        @if ($project->ended_at)
                                            {{ $project->ended_at }}
                                        @else
                                            <x-empty-data />
                                        @endif
                                    </x-slot>
                                    <x-slot name="second">
                                        {{ $project->started_at }}
                                    </x-slot>
                                </x-table.td>

                                <x-table.td class="w-4/12">
                                    <x-slot name="first" class="flex items-center font-bold" override="class">
                                        <x-link href="{{ route('projects.projects.show', $project->id) }}" override="class">
                                            <div class="truncate">
                                                {{ $project->name }}
                                            </div>
                                        </x-link>
                                    </x-slot>
                                    <x-slot name="second" class="font-normal truncate" override="class">
                                        <x-link href="{{ route('projects.projects.show', $project->id) }}" override="class">
                                            {{ $project->description }}
                                        </x-link>
                                    </x-slot>
                                </x-table.td>

                                <x-table.td class="w-2/12" hidden-mobile>
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-xl bg-{{ $project->status_label }} text-text-{{ $project->status_label }}">
                                        {{ $project->trans_status }}
                                    </span>
                                </x-table.td>

                                <x-table.td class="relative w-4/12" kind="right">
                                    <x-slot name="first" class="flex items-center justify-end font-bold" override="class">
                                        <div class="truncate">
                                            {{ $project->customer->name }}
                                        </div>
                                    </x-slot>
                                    <x-slot name="second">
                                        <div class="relative flex justify-end shrink-0 items-center -space-x-3 overflow-hidden">
                                            @foreach ($project->users->take(5) as $user)
                                                <x-link href="{{ route('users.edit', $user->user_id) }}" override="class" target="_blank">
                                                @php
                                                    $user = $user->user;
                                                    $user_count = count($project->users);
                                                    $zindex = match ($loop->index) {
                                                        0       => 'z-50',
                                                        1       => 'z-40',
                                                        2       => 'z-30',
                                                        3       => 'z-20',
                                                        4       => 'z-10',
                                                        default => 'z-0',
                                                    };
                                                @endphp

                                                @continue(is_null($user))

                                                @if (setting('default.use_gravatar', '0') == '1')
                                                    <img src="{{ $user->picture }}" class="w-6 h-6 rounded-full {!! $zindex !!}" title="{{ $user->name }}" alt="{{ $user->name }}">
                                                @elseif (is_object($user->picture))
                                                    <img src="{{ Storage::url($user->picture->id) }}" class="w-6 h-6 rounded-full {!! $zindex !!}" alt="{{ $user->name }}" title="{{ $user->name }}">
                                                @else
                                                    <img src="{{ asset('public/img/user.svg') }}" class="w-6 h-6 rounded-full {!! $zindex !!}" alt="{{ $user->name }}"/>
                                                @endif
                                                </x-link>
                                            @endforeach
                                            @if ($user_count > 5)
                                                <div class="pl-2.5">
                                                    <span class="w-6 h-6 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center">
                                                        +{{ count($project->users) - 5 }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </x-slot>
                                </x-table.td>

                                <x-table.td kind="action">
                                    <x-table.actions :model="$project" />
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.tbody>
                </x-table>
                <x-pagination :items="$projects" />
            </x-index.container>
        @else
            <x-empty-page group="projects" page="projects" />
        @endif
    </x-slot>

    <x-script alias="projects" file="projects" />
</x-layouts.admin>
