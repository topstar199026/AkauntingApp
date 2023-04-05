@php
    $is_portal = user()->isCustomer() ? 'portal.' : '';
@endphp

<x-form id="form-create-discussions" :route="[$is_portal . 'projects.discussions.store', $models->project->id]">
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
