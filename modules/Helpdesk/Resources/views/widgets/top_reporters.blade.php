<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => ''])

    @if ($reporters->count())
        <ul class="text-sm space-y-3 my-3">
            @foreach($reporters as $reporter)
                <li class="flex justify-between truncate">
                    {{ $reporter->name }}
                    <span class="font-medium">{{ $reporter->helpdesk_tickets_reporter_count }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-sm space-y-3 my-3">
            {{ trans('general.no_records') }}
        </div>
    @endif
</div>
