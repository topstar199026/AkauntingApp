<x-layouts.admin>
    <x-slot name="title">
        {{ $project->name }}
    </x-slot>

    <x-slot name="status">
        <x-show.status
            text-status="{{ $project->trans_status }}"
            background-color="bg-{{ $project->status_label }}"
            text-color="text-text-{{ $project->status_label }}"
        />
    </x-slot>

    <x-slot name="buttons">
        <x-dropdown id="show-new-actions-project">
            <x-slot name="trigger" class="flex items-center px-3 py-1.5 mb-3 sm:mb-0 bg-green hover:bg-green-700 rounded-xl text-white text-sm font-bold leading-6" override="class">
                {{ trans('general.new_more') }}
                <span class="material-icons ltr:ml-2 rtl:mr-2">expand_more</span>
            </x-slot>

            @can('create-projects-invoices')
                <x-dropdown.button @click="onModalAddNew('{{ route('projects.invoice', $project->id) }}')">
                    {{ trans_choice('projects::general.invoices', 1) }}
                </x-dropdown.button>
            @endcan

            @foreach(['tasks', 'timesheets', 'milestones', 'discussions'] as $type)
                @can('create-projects-' . $type)
                    <x-dropdown.button @click="onModalAddNew('{{ route('projects.' . $type . '.create', $project->id) }}')">
                        {{ trans_choice('projects::general.' . $type, 1) }}
                    </x-dropdown.button>
                @endcan
            @endforeach
        </x-dropdown>

        @can('update-projects-projects')
            <x-link href="{{ route('projects.projects.edit', $project->id) }}">
                {{ trans('general.edit') }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="content">
        <x-loading.content />

        <x-show.container>
            <div class="flex items-center justify-center text-black mt-10 mb-10">
                @widget('Modules\Projects\Widgets\TotalInvoice', $project)
                @widget('Modules\Projects\Widgets\TotalRevenue', $project)
                @widget('Modules\Projects\Widgets\TotalBill', $project)
                @widget('Modules\Projects\Widgets\TotalPayment', $project)
            </div>

            <div class="my-5">
                <x-tabs class="flex overflow-x-scroll large-overflow-unset" override="class" active="overview">
                    <x-slot name="navs">
                        @foreach ($tabs as $tab)
                            @stack($tab . '_nav_start')

                                <x-tabs.nav
                                    id="{{ $tab }}"
                                    name="{{ trans_choice('projects::general.' . $tab, 2) }}"
                                />

                            @stack($tab . '_nav_end')
                        @endforeach
                    </x-slot>

                    <x-slot name="content">
                        @foreach ($tabs as $tab)
                            @stack($tab . '_tab_start')

                            <x-tabs.tab id="{{ $tab }}" class="mt-5">
                                <x-dynamic-component
                                    :component="'projects::' . $tab"
                                    :project="$project"
                                    :search-string="${'searchString' . ucfirst($tab)} ?? null"
                                />
                            </x-tabs.tab>

                            @stack($tab . '_tab_end')
                        @endforeach
                    </x-slot>
                </x-tabs>
            </div>
        </x-show.container>
    </x-slot>

    <x-script alias="projects" file="shows" />
</x-layouts.admin>
