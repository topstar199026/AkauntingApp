@stack('footer_start')
    <footer class="footer">
        <div class="flex flex-col sm:flex-row items-center justify-between lg:mt-20 py-7 text-sm font-light">
            <div>
                <span>© 2023 AT-Technologies GmbH</span> |
{{--                {{ trans('footer.powered') }}:--}}
{{--                <a href="{{ trans('footer.link') }}" target="_blank">{{ trans('footer.software') }}</a> |--}}
                {{ trans('footer.version') }} {{ version('short') }}
            </div>
        </div>
    </footer>
@stack('footer_end')
