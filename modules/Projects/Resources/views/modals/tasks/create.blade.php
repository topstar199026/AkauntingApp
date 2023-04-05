@php
    $is_portal = user()->isCustomer() ? 'portal.' : '';
@endphp

<x-form id="form-create-tasks" method="POST" :route="[$is_portal . 'projects.tasks.store', $models->project->id]" :model="$models->task ?? false">
    <div class="grid sm:grid-cols-6 gap-x-8 gap-y-6 my-3.5">
        <x-form.group.text
            name="name"
            :label="trans('general.name')"
        />

        <x-form.group.money
            name="hourly_rate"
            :label="trans('projects::general.rate_per_hour')"
            :currency="$currency"
            :v-show="$is_task_hours"
            value="0"
        />

        <x-form.group.select
            name="milestone_id"
            :label="trans_choice('projects::general.milestones', 1)"
            :options="$milestones"
            not-required
        />

        <x-form.group.date
            name="started_at"
            :label="trans('general.start_date')"
            value="{{ Date::now()->toDateString() }}"
            :show-date-format="company_date_format()"
        />

        <x-form.group.date
            name="deadline_at"
            :label="trans('general.end_date')"
            :show-date-format="company_date_format()"
            not-required
        />

        <x-form.group.select
            name="priority"
            :label="trans_choice('projects::general.priorities', 1)"
            :options="$priorities"
            not-required
        />

        <x-form.group.select
            name="users"
            :label="trans_choice('projects::general.members', 2)"
            :options="$users"
            :selected="isset($models->task) ? $models->task->users->pluck('user_id') : []"
            multiple
            collapse
            not-required
        />

        <x-form.group.textarea
            name="description"
            :label="trans('general.description')"
            not-required
        />

        <x-projects::form.attachment />

        <x-form.input.hidden name="project_id" :value="$models->project->id" />
        <x-form.input.hidden name="status" value="active" />
    </div>
</x-form>
