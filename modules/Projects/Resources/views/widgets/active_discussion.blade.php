<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => ''])

    <ul class="text-sm space-y-3 my-3">
        @foreach($discussions as $discussion)
            <li class="flex flex-items justify-between">
                <div class="w-3/3 cursor-pointer" @click="onModalAddNew('{{ route('projects.discussions.show', [$discussion->project->id, $discussion->id]) }}')">
                    {{ $discussion->subject }}
                </div>
            </li>
        @endforeach
    </ul>
</div>
