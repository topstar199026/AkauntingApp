<x-form id="form-create-invoice" :route="['projects.invoice.store', $project->id]">
    <div class="grid sm:grid-cols-6 gap-x-8 gap-y-6 my-3.5">
        <x-form.group.select
            name="project_invoicing_type"
            :label="trans_choice('general.invoices', 1) . ' ' . trans('projects::general.info')"
            :options="$project_invoicing_type"
            form-group-class="sm:col-span-6"
        />

        <div class="sm:col-span-6">
            @foreach (['single_line', 'task_per_item', 'all_timesheets_individually'] as $name)
                <span class="mb-5" v-if="form.project_invoicing_type == '{{ $name }}'">{!! trans('projects::general.tooltips.' . $name) !!}</span>
            @endforeach
        </div>

        <div class="sm:col-span-6">
            {{ trans('projects::general.invoiced_tasks') }}
        </div>

        <div class="sm:col-span-6">
            <div class="text-red text-sm mt-1 block"
                v-if="form.errors.has('tasks')"
                v-html="form.errors.get('tasks')">
            </div>

            <x-table>
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th class="ltr:pr-6 rtl:pl-6" override="class">
                            <x-form.input.checkbox not-required @click="toggleAllCheckboxes($event)" />
                        </x-table.th>

                        <x-table.th class="w-4/12">
                            {{ trans('general.name') }}
                        </x-table.th>

                        <x-table.th class="w-4/12">
                            {{ trans_choice('general.statuses', 1) }}
                        </x-table.th>

                        <x-table.th class="w-4/12" kind="right">
                            {{ trans_choice('projects::general.priorities', 1) }}
                        </x-table.th>
                    </x-table.tr>
                </x-table.thead>

                <x-table.tbody>
                    @foreach($project->tasks as $item)
                        @continue($item->is_invoiced)
                        <x-table.tr>
                            <x-table.td class="ltr:pr-6 rtl:pl-6" override="class">
                                <x-form.input.checkbox selectable name="tasks[{{ $item->id }}]" value="false" not-required @click="toggleCheckboxes('tasks[{{ $item->id }}]')" />
                            </x-table.td>

                            <x-table.td class="w-4/12">
                                {{ $item->name }}
                            </x-table.td>

                            <x-table.td class="w-4/12">
                                <span class="flex items-center">
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-xl bg-{{ $item->status_color }} text-text-{{ $item->status_color }}">
                                        {{ trans("projects::general.$item->status") }}
                                    </span>
                                </span>
                            </x-table.td>

                            <x-table.td class="w-4/12" kind="right">
                                @if($item->priority)
                                    {{ trans("projects::general.$item->priority") }}
                                @else
                                    <x-empty-data />
                                @endif
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.tbody>
            </x-table>
        </div>
    </div>
</x-form>
