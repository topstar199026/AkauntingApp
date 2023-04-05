<x-form 
    id="form-update-discussions"
    method="PATCH"
    :route="['projects.discussions.update', [$models->project->id, $models->discussion->id]]" :model="$models->discussion">

    <div class="grid sm:grid-cols-6 gap-x-8 gap-y-6 my-3.5">
        <x-form.group.text
            name="subject"
            :label="trans('general.subject')"
            form-group-class="sm:col-span-6"
        />

        <x-form.group.textarea
            name="description"
            :label="trans('general.description')"
        />
    </div>
</x-form>
