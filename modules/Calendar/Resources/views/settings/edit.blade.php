<x-layouts.admin>
    <x-slot name="title">{{ trans('calendar::general.name') }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="calendar" method="POST" route="calendar.settings.update">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('calendar::general.name') }}" description="{{ trans('calendar::general.description') }}" />
                    </x-slot>
    
                    <x-slot name="body">
                        <x-form.group.select name="first_day" label="{{ trans('calendar::general.first_day') }}" :options="$days" :selected="old('first_day', setting('calendar.first_day'))" not-required />
    
                        <x-form.group.toggle name="enabled" label="{{ trans('calendar::general.enabled') }}" :value="setting('calendar.holidays.enabled')" not-required />
                    </x-slot>
                </x-form.section>
    
                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons :cancel="url()->previous()" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="calendar" file="setting" />
</x-layouts.admin>
