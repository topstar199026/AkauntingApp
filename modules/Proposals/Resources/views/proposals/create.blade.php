<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.new', ['type' => trans_choice('proposals::general.proposals', 1)]) }}
    </x-slot>

    <x-slot name="content">
        @mobile
            <div class="w-full lg:w-8/12 flex items-center ltr:right-4 rtl:left-4 py-2 px-4 font-bold text-sm my-5 rounded-lg bg-orange-100 text-orange-600" role="alert">
                <strong>{{ trans('proposals::general.warning.mobile') }}</strong>
            </div>
        @endmobile

        <x-form.container class="w-full" override="class">
            <x-form id="proposal" route="proposals.proposals.store">
                <x-form.section>
                    <x-slot name="body">
                        <x-form.group.text name="description" label="{{ trans('general.description') }}" />

                        <x-form.group.select name="template_id" label="{{ trans_choice('general.templates', 1) }}" :options="$templates" change="onChangeTemplate" not-required />

                        @if($module_estimates)
                            <x-form.group.select name="estimates_id" label="{{ trans_choice('estimates::general.estimates', 1) }}" :options="$estimates" not-required />
                        @endif

                        @if($module_crm)
                            <div id="proposal-create-deal" class="sm:col-span-6">
                                <x-form.group.toggle name="create_deal" label="{{ trans('proposals::general.create_deal') }}" id="create_deal" v-model="form.create_deal" @input="onCreateDeal($event)" form-group-class="sm:col-span-3" not-required />
                            </div>
                        @endif

                        <x-form.input.hidden name="content_html" v-model="form.content_html" />
                        <x-form.input.hidden name="content_css" v-model="form.content_css" />
                        <x-form.input.hidden name="content_components" v-model="form.content_components" />
                        <x-form.input.hidden name="content_style" v-model="form.content_style" />
                    </x-slot>
                </x-form.section>

                <x-form.section v-if="form.create_deal">
                    <x-slot name="body">
                        <x-form.group.select name="crm_contact_id" label="{{ trans_choice('crm::general.contacts',1) }}" :options="$contacts" />

                        <x-form.group.select name="crm_company_id" label="{{ trans_choice('crm::general.companies',1) }}" :options="$companies" />

                        <x-form.group.text name="name" label="{{ trans('general.name') }}" />

                        <x-form.group.money name="amount" label="{{ trans('general.amount') }}" value="0" autofocus="autofocus" :currency="$currency" dynamicCurrency="currency" />

                        <x-form.group.select name="owner_id" label="{{ trans('crm::general.owner') }}" :options="$owners" />

                        <x-form.group.select name="pipeline_id" label="{{ trans('crm::general.pipeline') }}" :options="$pipelines" />

                        <x-form.group.color name="color" label="{{ trans('general.color') }}" />

                        <x-form.group.date name="closed_at" label="{{ trans('crm::general.closed_at') }}" icon="calendar_today" date-format="Y-m-d" autocomplete="off" />
             
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="body">
                        <div class="sm:col-span-6" id="gjs"></div>
                    </x-slot>
                </x-form.section>

                @permission('create-proposals-proposals')
                    <x-form.section>
                        <x-slot name="foot">
                            <x-form.buttons cancel-route="proposals.proposals.index" />
                        </x-slot>
                    </x-form.section>
                @endpermission
            </x-form>
        </x-form.container>
    </x-slot>

@push('css')
    <link href="{{ asset('modules/Proposals/Resources/assets/css/grapes.min.css?v=' . module_version('proposals')) }}" rel="stylesheet"/>
    <link href="{{ asset('modules/Proposals/Resources/assets/css/grapesjs-preset-webpage.min.css?v=' . module_version('proposals')) }}" rel="stylesheet"/>
    <style type="text/css">
        .gjs-block.fa, .gjs-pn-btn, .gjs-toolbar-item.fa, .gjs-layer-move .fa, .gjs-no-touch-actions .fa {
            font-family: "FontAwesome";
        }

        .gjs-editor {
            overflow-x: scroll;
        }
    </style>
@endpush

@push('scripts_start')
    <x-script alias="proposals" file="proposals" />
    <script src="{{ asset('modules/Proposals/Resources/assets/js/grapes.min.js?v=' . module_version('proposals')) }}"></script>
    <script src="{{ asset('modules/Proposals/Resources/assets/js/grapesjs-preset-webpage.min.js?v=' . module_version('proposals')) }}"></script>

    <script type="text/javascript">
        var editor = grapesjs.init({
            container : '#gjs',
            plugins: ['gjs-preset-webpage'],
            storageManager: {
                autoload: false,
                type: 'simple-storage',
            },
            colorPicker: { appendTo: 'parent', offset: { top: 26, left: -155, }, }
        });

        // Here our `simple-storage` implementation
        const SimpleStorage = {};

        editor.StorageManager.add('simple-storage', {
            /**
             * Load the data
             * @param  {Array} keys Array containing values to load, eg, ['gjs-components', 'gjs-style', ...]
             * @param  {Function} clb Callback function to call when the load is ended
             * @param  {Function} clbErr Callback function to call in case of errors
             */
            load(keys, clb, clbErr) {
                const result = {};

                keys.forEach(key => {
                const value = SimpleStorage[key];
                if (value) {
                    result[key] = value;
                }
                });

                // Might be called inside some async method
                clb(result);
            },

            /**
             * Store the data
             * @param  {Object} data Data object to store
             * @param  {Function} clb Callback function to call when the load is ended
             * @param  {Function} clbErr Callback function to call in case of errors
             */
            store(data, clb, clbErr) {
                for (let key in data) {
                SimpleStorage[key] = data[key];
                }
                // Might be called inside some async method
                clb();
            }
        });

        editor.on('storage:end:store', () => {
            app.__vue__.form.content_html = editor.getHtml();
            app.__vue__.form.content_css = editor.getCss();
            app.__vue__.form.content_components = JSON.stringify(editor.getComponents());
            app.__vue__.form.content_style = JSON.stringify(editor.getStyle());
        });

        editor.runCommand('core:component-outline');
    </script>
@endpush
</x-layouts.admin>
