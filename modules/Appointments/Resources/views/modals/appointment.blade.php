<x-form id="form-create-appointment" route="appointments.modals.appointments.store">
    <x-form.section>
        <x-slot name="body">
            <x-form.group.time name="starting_time" label="{{ trans('appointments::general.starting_time') }}" id="starting_time" :value="$starting_hour" disabled time_24hr=true autocomplete="off" />

            <x-form.group.time name="ending_time" label="{{ trans('appointments::general.ending_time') }}" id="ending_time" :value="$ending_hour" disabled time_24hr=true autocomplete="off" />

            <x-form.group.date name="date" label="{{ trans('general.date') }}" icon="calendar" value="{{ Date::parse($date)->toDateString() }}" show-date-format="{{ company_date_format() }}" disabled date-format="Y-m-d" autocomplete="off" />

            <x-form.group.text name="name" label="{{ trans('general.name') }}" />

            <x-form.group.text name="email" label="{{ trans('general.email') }}" />

            <x-form.group.text name="phone" label="{{ trans('general.phone') }}" />

            <x-form.input.hidden name="appointment_id" :value="$request->appointment_id" />

            <x-form.input.hidden name="employee_id" :value="$request->employee_id" />
        </x-slot>
    </x-form.section>
</x-form>