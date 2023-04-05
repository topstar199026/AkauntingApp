<x-show.no-records image="modules/Projects/Resources/assets/img/no_records/{{ $name }}.png" :description="trans('projects::general.no_records.' . $name)">
    <x-slot name="button">
        <button
            type="button"
            @click="onModalAddNew('{{ route('projects.' . $name . '.create', $project->id) }}')">
            <span class="bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize hover:bg-full-2 to-white">
                {{ trans('general.title.new', ['type' => trans_choice('projects::general.' . $name, 1)]) }}
            </span>
        </button>
    </x-slot>
</x-show.no-records>
