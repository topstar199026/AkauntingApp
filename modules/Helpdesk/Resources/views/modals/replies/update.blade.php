<div class="py-1 px-5 bg-body">
    <div class="w-full mb-2">
        <label for="message"
            class="block form-control-label mb-2">{{ trans('helpdesk::general.reply.message') }}</label>
        <textarea class="w-full" placeholder="{{ trans('helpdesk::general.reply.message') }}"
            value="{{ trans('helpdesk::general.message') }}" v-model="update_reply_form.message" rows="3"
            name="message" id="message">
            </textarea>
        <div class="text-red text-sm mt-1 block" v-if="update_reply.errors">
            {{ trans('validation.required', ['attribute' => Str::lower(trans('helpdesk::general.reply.message'))]) }}
        </div>
    </div>

    @can('update-helpdesk-replies')
        <div class="form-group sm:col-span-3">
            <input type="checkbox" name="internal" id="internal" v-model="update_reply_form.internal"
                class="rounded-sm text-purple border-gray-300 cursor-pointer disabled:bg-gray-200 focus:outline-none focus:ring-transparent" />

            <x-form.label for="internal" class="form-control-label">
                {{ trans('helpdesk::general.reply.internal_note') }}</x-form.label>
        </div>
    @endcan
</div>
