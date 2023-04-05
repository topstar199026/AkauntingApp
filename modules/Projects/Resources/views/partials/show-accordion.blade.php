<x-show.accordion type="projects">
    <x-slot name="head">
        <x-show.accordion.head
            :title="trans('projects::general.title')"
            :description="trans('projects::general.show_accordion.description')"
        />
    </x-slot>

    <x-slot name="body">
        <span class="font-medium">
            @php($link = '<a
                            href="' . route('projects.projects.show', $project->id) . '"
                            class="to-black-400 hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize"
                           >' . $project->name . '</a>')

            {!! trans('projects::general.show_accordion.project', ['project' => $link]) !!}
        </span>
    </x-slot>
</x-show.accordion>
