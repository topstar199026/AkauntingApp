<x-form.accordion type="advanced">
    <x-slot name="head">
        <x-form.accordion.head
            title="{{ trans_choice($textSectionAdvancedTitle, 1) }}"
            description="{{ trans($textSectionAdvancedDescription, ['type' => $type]) }}"
        />
    </x-slot>

    <x-slot name="body">
        @stack('footer_start')

        @if (! $hideFooter)
            <div class="{{ $classFooter }}">
                <x-form.group.textarea name="footer" label="{{ trans('general.footer') }}" class="h-full" :value="$footer" not-required rows="10" />
            </div>
        @endif

        <div class="sm:col-span-4 grid gap-x-8 gap-y-1">
            @stack('category_start')

            @if (! $hideCategory)
                <div class="{{ $classCategory }}">
                    <x-form.group.category :type="$typeCategory" :selected="$categoryId" />
                </div>
            @else
                <x-form.input.hidden name="category_id" :value="$categoryId" />
            @endif

            {{-- atg-account footer start--}}
                @php
                    $account_at = array(
                        '1' => 'DE66 3406 0094 0107 1185 49  Volksbank Remscheid Solingen',
                        '2' => 'DE02 3602 0030 0007 0683 95  NATIONAL-BANK',
                        '3' => 'DE71 3406 0094 0107 1185 40  Volksbank Remscheid Solingen',
                        '4' => 'DE43 3405 0000 0000 1314 58  Sparkasse Remscheid',
                        '5' => 'DE95 3405 0000 0000 1323 65  Sparkasse Remscheid',
                        '6' => 'DE50 3507 0024 0555 9299 00  Deutsche Bank'
                    );
                @endphp

                <x-form.group.select
                    name="atg_footer_account"
                    form-group-class="sm:col-span-4 grid gap-x-8 gap-y-3"
                    label="{{ trans('general.atg_footer_account') }}"
                    :options="$account_at"
                />
            {{--  atg-account footer end--}}

            @stack('attachment_end')

            @if (! $hideAttachment)
                <div class="{{ $classAttachment }}">
                    <x-form.group.attachment />
                </div>
            @endif
        </div>
    </x-slot>
</x-form.accordion>
