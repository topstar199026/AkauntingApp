<x-layouts.admin>
    <x-slot name="title">{{ trans('appointments::general.name') }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="appointment" method="POST" route="appointments.settings.update">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.time name="appointment_duration" label="{{ trans('appointments::general.appointment_duration') }}" id="appointment_duration" :value="old('appointment_duration', setting('appointments.appointment_duration'))" time_24hr=true autocomplete="off" />

                        <x-form.group.select name="reminders" label="{{ trans('appointments::general.reminders') }}" :options="$reminders" :selected="old('reminders', setting('appointments.reminders'))" form-group-class="sm:col-span-3" />

                        <x-form.group.number name="before_schedule_appointment" label="{{ trans('appointments::general.before_schedule_appointment') }}" :value="old('before_schedule_appointment', setting('appointments.before_schedule_appointment'))" max=24 />

                        <x-form.group.number name="after_schedule_appointment" label="{{ trans('appointments::general.after_schedule_appointment') }}" :value="old('after_schedule_appointment', setting('appointments.after_schedule_appointment'))" max=30 />

                        <x-form.group.number name="allow_cancelled" label="{{ trans('appointments::general.allow_cancelled') }}" :value="old('allow_cancelled', setting('appointments.allow_cancelled'))" max=24 />

                        <x-form.group.select name="recurring" label="{{ trans('recurring.recurring') }}" :options="$recurring" :selected="old('recurring', setting('appointments.recurring'))" form-group-class="sm:col-span-3" />

                        <x-form.group.select multiple name="question_ids" label="{{ trans_choice('appointments::general.questions', 2) }}" :options="$questions" :selected="old('question_ids', json_decode(setting('appointments.question_ids', '')))" not-required form-group-class="sm:col-span-3 el-select-tags-pl-38" />

                        <x-form.group.select multiple name="week_days" label="{{ trans('appointments::general.week_day') }}" :options="$week_days" :selected="old('week_days', json_decode(setting('appointments.week_days', '')))" form-group-class="sm:col-span-3 el-select-tags-pl-38" />
                      
                        <x-form.group.time name="starting_time" label="{{ trans('appointments::general.starting_time') }}" id="starting_time" :value="old('starting_time', setting('appointments.starting_time'))" time_24hr=true autocomplete="off" />

                        <x-form.group.time name="ending_time" label="{{ trans('appointments::general.ending_time') }}" id="ending_time" :value="old('ending_time', setting('appointments.ending_time'))" time_24hr=true autocomplete="off" />

                        <x-form.group.toggle name="approval_control" label="{{ trans('appointments::general.approval_control') }}" :value="old('approval_control', setting('appointments.approval_control'))" not-required form-group-class="sm:col-span-6" />
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

    @push('scripts_start')
        <script type="text/javascript">
            var events = [];
            var calendar_locale = '{{ strtolower(language()->getShortCode()) }}';
            var calendar_country = '{{ setting('company.country', 'GB') }}';
        </script>
    @endpush

    <x-script alias="appointments" file="appointments" />
</x-layouts.admin>
