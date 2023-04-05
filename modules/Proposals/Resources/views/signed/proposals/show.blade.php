<div class="w-full lg:max-w-6xl m-auto">
<x-layouts.signed>
    <x-slot name="title">
        {{ trans_choice('proposals::general.proposals', 1) }}
    </x-slot>

    <x-slot name="buttons">
        <x-link href="{{ $approveAction }}" kind="primary">
            {{ trans('proposals::general.approve') }}
        </x-link>

        <x-link href="{{ $refuseAction }}">
            {{ trans('proposals::general.refuse') }}
        </x-link>

        <x-link href="{{ $downloadAction }}">
            {{ trans('general.download') }}
        </x-link>

        <x-link href="{{ route('portal.dashboard') }}">
            {{ trans('proposals::general.all_proposals') }}
        </x-link>
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-col lg:flex-row my-10 lg:space-x-24 rtl:space-x-reverse space-y-12 lg:space-y-0">
            <div class="proposal">
                {!! $content_html !!}
            </div>
        </div>
    </x-slot>

    @push('css')
        <style type="text/css">
            .proposal {
                all: initial;
            }

            {!! str_replace('.row', '.proposal .row', $content_css) !!}
        </style>
    @endpush

    <x-script folder="portal" file="proposals" />
</x-layouts.signed>
</div>
