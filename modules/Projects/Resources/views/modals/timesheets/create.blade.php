<x-form id="form-create-timesheet" :route="['projects.timesheets.store', $models->project->id]">
    <div class="grid sm:grid-cols-6 gap-x-8 gap-y-6 my-3.5">
        <x-form.group.date_time
            name="started_at"
            :label="trans('general.start_date')"
            :show-date-format="company_date_format() . ' H:i'"
        />

        <x-form.group.date_time
            name="ended_at"
            :label="trans('general.end_date')"
            :show-date-format="company_date_format() . ' H:i'"
        />

        <x-form.group.select
            name="task_id"
            :label="trans_choice('projects::general.tasks', 1)"
            :options="$tasks"
            {{-- change="updateUsers" --}}
        />

        <x-form.group.select
            name="user_id"
            :label="trans_choice('projects::general.members', 1)"
            :options="$users"
            {{-- dynamicOptions="usersByTask" --}}
        />

        <x-form.group.textarea
            name="note"
            :label="trans_choice('general.notes', 1)"
            not-required
        />

        <x-form.input.hidden name="project_id" :value="$models->project->id" />
        <x-form.input.hidden name="users" value="{{ json_encode($users) }}" />
    </div>
</x-form>