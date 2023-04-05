<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => 'border-b-0'])

    <div class="my-3 text-black-400 text-sm">
        {{ $total_text }}: <span class="font-bold">{{ $total }}</span>
    </div>

    <div class="my-3" aria-hidden="true">
        <div @class(['h-3', 'rounded-md', 'bg-red-300' => true, 'bg-gray-300' => ! true])>
            <div @class(['h-3', 'rounded-md', 'bg-orange-300' => true, 'bg-gray-300' => ! true]) style="width: {{ $percentage }}%;"></div>
        </div>
    </div>
</div>
