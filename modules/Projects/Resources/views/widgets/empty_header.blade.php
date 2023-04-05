<div class="pb-2 my-4 lg:my-0{{ !empty($header_class) ? ' ' . $header_class : '' }}">
    <div class="flex justify-between font-medium mb-2">
        <h2 class="text-black" title="{{ $class->model->name }}">
            {{ $class->model->name }}
        </h2>

        <div class="flex items-center">
            @if ($report = $class->getReportUrl())
                <x-link href="{{ $report }}" class="text-purple text-sm mr-3 text-right" override="class">
                    <x-link.hover color="to-purple">
                        {{ trans('widgets.view_report') }}
                    </x-link.hover>
                </x-link>
            @endif
        </div>
    </div>

    <span class="h-6 block border-b text-black-400 text-xs truncate">
        {{ $class->getDescription() }}
    </span>
</div>