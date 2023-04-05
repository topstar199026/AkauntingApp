<div class="grid grid-cols-2 py-1 px-5 bg-body flex flex-col justify-center">
    <div class="group relative p-2.5">
        <button class="flex items-center" @click="onEventAction('show')">
            <div class="w-6 h-6 flex items-center justify-center">
                <x-icon icon="visibility"></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans('general.show') }}</span>
        </button>
    </div>
   
    <div class="group relative p-2.5">
        <button class="flex items-center" @click="onEventAction('edit')">
            <div class="w-6 h-6 flex items-center justify-center">
                <x-icon icon="edit"></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans('general.edit') }}</span>
        </button>
    </div>

    <div class="group relative p-2.5">
        <button class="flex items-center" @click="onEventAction('ical')">
            <div class="w-6 h-6 flex items-center justify-center">
                <x-icon icon="apple" simple-icons ></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans('calendar::general.ical') }}</span>
        </button>
    </div>

    <div class="group relative p-2.5">
        <button class="flex items-center" @click="onEventAction('google_calendar')">
            <div class="w-6 h-6 flex items-center justify-center">
                <x-icon icon="googlecalendar" simple-icons ></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans('calendar::general.google_calendar') }}</span>
        </button>
    </div>

    <div class="group relative p-2.5">
        <button class="flex items-center" @click="onEventAction('outlook')">
            <div class="w-6 h-6 flex items-center justify-center">
                <x-icon icon="microsoftoutlook" simple-icons></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans('calendar::general.outlook') }}</span>
        </button>
    </div>

    <div class="group relative p-2.5">
        <button class="flex items-center" @click="onEventAction('office365')">
            <div class="w-6 h-6 flex items-center justify-center">
                <x-icon icon="microsoftoffice" simple-icons></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans('calendar::general.office365') }}</span>
        </button>
    </div>

    <div class="group relative p-2.5">
        <button class="flex items-center" @click="onEventAction('yahoo')">
            <div class="w-6 h-6 flex items-center justify-center">
                <x-icon icon="yahoo" simple-icons ></x-icon>
            </div>
            <span class="text-sm ltr:ml-2 rtl:mr-2">{{ trans('calendar::general.yahoo') }}</span>
        </button>
    </div>
</div>
