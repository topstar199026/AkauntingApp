<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => ''])

    @if ($latest_tickets->count())
        <ul class="text-sm space-y-3 my-3">
            @foreach($latest_tickets as $ticket)
                <li class="flex truncate">
                    {{ $ticket->name }}
                    <span class="font-medium">&nbsp;{{ $ticket->category->name }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-sm space-y-3 my-3">
            {{ trans('general.no_records') }}
        </div>
    @endif
</div>