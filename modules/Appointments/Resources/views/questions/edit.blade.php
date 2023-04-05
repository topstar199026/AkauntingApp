<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.edit', ['type' => trans_choice('appointments::general.questions', 1)]) }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="question" method="PATCH" :route="['appointments.questions.update', $question->id]" :model="$question">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="question" label="{{ trans_choice('appointments::general.questions', 1) }}" />

                        <x-form.group.select name="question_type" label="{{ trans('appointments::general.question_types') }}" :options="$question_type" :selected="$question->question_type" change="onSelectType" form-group-class="sm:col-span-3" />

                        <x-form.group.toggle name="required_answer" label="{{ trans('appointments::general.required_answer') }}" value=1 not-required form-group-class="sm:col-span-6" />

                        <x-form.input.hidden name="enabled" :value="$question->enabled" />
                    </x-slot>
                </x-form.section>

                <div v-if="type_select">
                    <x-form.section>
                        <x-slot name="head">
                            <x-form.section.head title="{{ trans('appointments::general.avaible_answer') }}" />
                        </x-slot>
                        <x-slot name="body">
                            <div class="sm:col-span-6">
                                <x-table>
                                    <x-table.thead>
                                        <x-table.tr class="flex items-center px-1">
                                            <x-table.th class="w-full hidden sm:table-cell">
                                                {{ trans('appointments::general.avaible_answer') }}
                                            </x-table.th>
                                        </x-table.tr>
                                    </x-table.thead>
                                
                                    <x-table.tbody>
                                        <x-table.tr class="flex items-center px-1 group border-b hover:bg-gray-100" v-for="(row, index) in form.items" ::index="index">                                   
                                            <x-table.td class="w-11/12 hidden sm:table-cell">
                                                <x-form.group.text name="items[][avaible_answer]" value="" data-item="avaible_answer" v-model="row.avaible_answer" />
                                            </x-table.td>

                                            <x-table.td class="w-1/12 hidden sm:table-cell none-truncate" override="class">
                                                <x-button type="button" @click="onDeleteItem(index)" class="px-3 py-1.5 mb-3 sm:mt-2 sm:mb-0 rounded-xl text-sm font-medium leading-6 hover:bg-gray-200 disabled:bg-gray-50" override="class">
                                                    <span class="w-full material-icons-outlined text-lg text-gray-300 group-hover:text-gray-500">delete</span>
                                                </x-button>
                                            </x-table.td>
                                        </x-table.tr>
                                        
                                        <x-table.tr id="addItem">
                                            <x-table.td class="w-full hidden sm:table-cell">
                                                <x-button type="button" override="class" @click="onAddItem" class="w-full text-secondary flex items-center justify-center" title="{{ trans('general.add') }}">
                                                    <span class="material-icons-outlined text-base font-bold mr-1">add</span>
                                                    {{ trans('general.form.add', ['field' => trans('appointments::general.answer')]) }}
                                                </x-button>
                                            </x-table.td>
                                        </x-table.tr>
                                    </x-table.tbody>
                                </x-table>
                            </div>
                        </x-slot>
                    </x-form.section>
                </div>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="appointments.questions.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    @push('scripts_start')
        <script type="text/javascript">
            var option_items ={!! json_encode($question->answers) !!};
        </script>
    @endpush

    <x-script alias="appointments" file="questions" />
</x-layouts.admin>