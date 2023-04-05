@php
    $file_type_mimes = explode(',', config('filesystems.mimes') . ',pdf,txt,doc,docs,xls,xlsx,cvs,zip');

    $file_types = [];

    foreach ($file_type_mimes as $mime) {
        $file_types[] = '.' . $mime;
    }

    $file_types = implode(',', $file_types);
@endphp

<x-form.group.file
    name="attachment"
    label="{{ trans('general.attachment') }}"
    singleWidthClasses
    not-required
    dropzone-class="w-full"
    multiple="multiple"
    :options="['acceptedFiles' => $file_types]"
    form-group-class="sm:col-span-6"
/>
