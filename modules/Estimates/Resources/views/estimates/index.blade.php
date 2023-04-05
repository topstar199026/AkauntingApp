<x-layouts.admin>
    <x-slot name="title">
        {{ setting('estimates.estimate.name', trans_choice('estimates::general.estimates', 2)) }}
    </x-slot>

    <x-slot name="favorite"
            title="{{ trans_choice('estimates::general.estimates', 2) }}"
            icon="check"
            route="estimates.estimates.index"
    ></x-slot>

    <x-slot name="buttons">
        <x-documents.index.buttons :type="$type" />
    </x-slot>

    <x-slot name="moreButtons">
        <x-documents.index.more-buttons :type="$type" />
    </x-slot>

    <x-slot name="content">
        <x-documents.index.content
           :type="$type"
           :documents="$estimates"
           :active-tab="$type"
           without-tabs
           hide-due-at
           hide-button-cancel
           hide-recurring-templates
        />
    </x-slot>

    <x-documents.script :type="$type" alias="core" />
</x-layouts.admin>
