<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => ''])

    @if ($assignees->count())
        <ul class="text-sm space-y-3 my-3">
            @foreach($assignees as $assignee)
                <li class="flex justify-between truncate">
                    {{ $assignee->name }}
                    <span class="font-medium">{{ $assignee->helpdesk_tickets_assignee_count }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-sm space-y-3 my-3">
            {{ trans('general.no_records') }}
        </div>
    @endif
</div>
