<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.edit', ['type' => trans_choice('proposals::general.pipelines', 1)]) }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="pipeline" method="PATCH" :route="['proposals.pipelines.update', $pipeline->id]" :model="$pipeline">
                <x-form.section>
                    <x-slot name="body">
                        <x-form.group.select name="stage_id_create" label="{{ trans('proposals::settings.crm_create') }}" :options="$stages" :selected="!empty($pipeline->stage_id_create) ? $pipeline->stage_id_create : null" />

                        <x-form.group.select name="stage_id_send" label="{{ trans('proposals::settings.crm_send') }}" :options="$stages" :selected="!empty($pipeline->stage_id_send) ? $pipeline->stage_id_send : null" />

                        <x-form.group.select name="stage_id_approve" label="{{ trans('proposals::settings.crm_approve') }}" :options="$stages" :selected="!empty($pipeline->stage_id_approve) ? $pipeline->stage_id_approve : null" />

                        <x-form.group.select name="stage_id_refused" label="{{ trans('proposals::settings.crm_refuse') }}" :options="$stages" :selected="!empty($pipeline->stage_id_refused) ? $pipeline->stage_id_refused : null" />
                    </x-slot>
                </x-form.section>

                @permission('update-proposals-pipelines')
                    <x-form.section>
                        <x-slot name="foot">
                            <x-form.buttons cancel-route="proposals.pipelines.index" />
                        </x-slot>
                    </x-form.section>
                @endpermission
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="proposals" file="pipelines" />
</x-layouts.admin>
