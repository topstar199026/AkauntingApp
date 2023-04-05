<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => ''])

    <ul class="text-sm space-y-3 my-3">
        @foreach($tasks as $task)
            <li class="flex flex-items justify-between">
                <div class="w-6/8">{{ $task->name }}</div>
                <div class="w-2/8">{{ $task->logged_time }}</div>
            </li>
        @endforeach
    </ul>
</div>
