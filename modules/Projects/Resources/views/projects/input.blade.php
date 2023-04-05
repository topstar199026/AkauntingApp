<x-form.group.select
    name="project_id"
    :label="trans_choice('projects::general.projects', 1)"
    :options="$projects"
    :selected="$selected"
    form-group-class="sm:col-span-{{ $size }}"
    not-required
/>