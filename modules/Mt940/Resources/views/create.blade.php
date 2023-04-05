<x-layouts.admin>
    <x-slot name="title">
        {{ trans('mt940::general.title') }}
    </x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form
                id="mt940"
                route="mt940.import">
                <x-form.section>
                    <x-slot name="body">
                        <x-form.group.file
                            name="import" 
                            :label="trans('mt940::general.mt940_import')"
                            :options="['acceptedFiles' => '.txt,.300,.940,.sta,.mt940,.mta']"
                        />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="mt940.create" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script
        alias="mt940"
        file="mt940"
    />
</x-layouts.admin>
