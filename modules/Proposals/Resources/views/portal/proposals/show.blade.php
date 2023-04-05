<x-layouts.portal>
    <x-slot name="title">
        {{ trans_choice('proposals::general.proposals', 1) }}
    </x-slot>

    <x-slot name="content">
        <div class="proposal">
            {!! $content_html !!}
        </div>
    </x-slot>

    @push('css')
        <style type="text/css">
            .proposal {
                all: initial;
            }

            .footer {
                margin: 30px 0;
            }

            {!! str_replace('.row', '.proposal .row', $content_css) !!}
        </style>
    @endpush

    <x-script folder="portal" file="proposals" />
</x-layouts.portal>
