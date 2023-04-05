<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => ''])

    <ul class="text-sm space-y-3 my-3">
        <li class="flex justify-between">
            {{ trans('projects::general.billing_type') }}

            <span class="font-medium">
                {{ trans('projects::general.' . str_replace('-', '_', $project->billing_type)) }}
            </span>
        </li>

        <li class="flex justify-between">
            {{ trans('general.start') }}

            <span class="font-medium">
                {{ Date::parse($project->started_at)->format($date_format) }}
            </span>
        </li>

        <li class="flex justify-between">
            @if($project->billing_type == 'projects-hours')
                {{ trans('projects::general.rate_per_hour') }}
            @else
                {{ trans('projects::general.total_rate') }}
            @endif

            <span class="font-medium">
                @if($project->billing_type != 'task-hours')
                    @money($project->billing_rate, setting('default.currency'), true)
                @else
                    -
                @endif
            </span>
        </li>

        <li class="flex justify-between">
            {{ trans('projects::general.deadline') }}

            <span class="font-medium">
                @if(isset($project->ended_at))
                    {{ Date::parse($project->ended_at)->format($date_format) }}
                @else
                    -
                @endif
            </span>
        </li>

        <li class="flex justify-between">
            {{ trans('projects::general.total') . ' ' . trans('projects::general.time_hourly') }}

            <span class="font-medium">
                {{ $total_logged_hours }}
            </span>
        </li>
    </ul>
</div>
