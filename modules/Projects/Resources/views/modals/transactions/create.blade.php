<x-form id="form-create-milestone" :route="['projects.milestones.store', $models->project->id]">
    <div class="grid sm:grid-cols-6 gap-x-8 gap-y-6 my-3.5">
        <x-form.group.text
            name="name"
            :label="trans('general.name')"
        />

        <x-form.group.date
            name="deadline_at"
            :label="trans('general.end_date')"
            :show-date-format="company_date_format()"
        />

        <x-form.group.textarea
            name="description"
            :label="trans('general.description')"
            not-required
        />

        <x-form.input.hidden name="project_id" :value="$models->project->id" />
    </div>
</x-form>
