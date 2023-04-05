<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }}">
    <div class="w-full">
        @include($class->views['header'])

        @livewire('calendar')
    </div>
</div>
