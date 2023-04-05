<x-layouts.portal>
    <x-slot name="title">
        {{ $project->name }}
    </x-slot>

    <x-slot name="status">
        <x-show.status text-status="{{ $project->trans_status }}" background-color="bg-{{ $project->status_label }}" text-color="text-text-{{ $project->status_label }}" />
    </x-slot>

    <x-slot name="buttons">
        @can('create-projects-portal-tasks')
            <x-button @click="onModalAddNew('{{ route('portal.projects.tasks.create', $project->id) }}')" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('projects::general.tasks', 1)]) }}
            </x-button>
        @endcan

        @can('create-projects-portal-discussions')
            <x-button @click="onModalAddNew('{{ route('portal.projects.discussions.create', $project->id)  }}')" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('projects::general.discussions', 1)]) }}
            </x-button>
        @endcan
    </x-slot>

    <x-slot name="content">
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
</x-layouts.portal>
