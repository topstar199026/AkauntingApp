<x-form id="attachment" method="post" :route="['projects.attachment.store', $project->id]">
    <div class="mb-5">
        <x-form.group.attachment />
    </div>

    <x-form.section>
        <x-slot name="foot">
            <x-form.buttons without-cancel />
        </x-slot>
    </x-form.section>

    @if (count($attachments))
        <div class="grid-rows-1">
            <x-table>
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th class="w-5/12">
                            <x-slot name="first">
                                {{ trans('projects::general.file_name') }}
                            </x-slot>
                            <x-slot name="second">
                                {{ trans('projects::general.file_size') }}
                            </x-slot>
                        </x-table.th>

                        <x-table.th class="w-5/12">
                            <x-slot name="first">
                                {{ trans_choice('projects::general.created_by', 2) }}
                            </x-slot>
                            <x-slot name="second">
                                {{ trans('projects::general.created_from') }}
                            </x-slot>
                        </x-table.th>

                        <x-table.th class="w-2/12" kind="right">
                            {{ trans('general.created_date') }}
                        </x-table.th>
                    </x-table.tr>
                </x-table.thead>

                <x-table.tbody>
                    @foreach($attachments as $file)
                        <x-table.tr href="{{ route('uploads.download', $file->id) }}">

                            <x-table.td class="w-5/12">
                                <x-slot name="first">
                                    <div class="flex flex-row items-center">
                                        <div class="avatar-attachment mr-2">
                                            @if ($file->aggregate_type == 'image')
                                                <img src="{{ route('uploads.get', $file->id) }}" alt="{{ $file->basename }}" class="avatar-img h-full rounded object-cover">
                                            @else
                                                <span class="material-icons text-base">attach_file</span>
                                            @endif
                                        </div>

                                        {{ $file->basename }}
                                    </div>
                                </x-slot>

                                <x-slot name="second">
                                    {{ $file->readableSize() }}
                                </x-slot>
                            </x-table.td>

                            @php
                                $user = \App\Models\Auth\User::find($file->created_by);
                                $picture = '';

                                if (setting('default.use_gravatar', '0') == '1') {
                                    $picture = $user->picture;
                                } elseif (is_object($user->picture)) {
                                    $picture = Storage::url($user->picture->id);
                                } else {
                                    $picture = asset('public/img/user.svg');
                                }
                            @endphp

                            <x-table.td class="w-5/12" data-tooltip-target>
                                <x-slot name="first">
                                    <div class="flex flex-row">
                                        <img src="{{ $picture }}" class="w-6 h-6 rounded-full mr-2 mb-1" alt="{{ $user->name }}"/>

                                        {{ $user->name }}
                                    </div>
                                </x-slot>

                                <x-slot name="second">
                                    @if ($file->pivot->mediable_type == 'Modules\Projects\Models\Project')
                                        <span class="text-xs font-medium">{{ trans('projects::general.created_from_project') }}</span>
                                    @elseif ($file->pivot->mediable_type == 'Modules\Projects\Models\Task')
                                        <x-button
                                            class="py-1.5 mb-3 sm:mb-0 text-xs bg-transparent hover:bg-transparent font-medium leading-6"
                                            override="class"
                                            @click="onModalAddNew('{{ route('projects.tasks.show', [$project->id, $file->pivot->mediable_id]) }}')"
                                        >
                                            <span class="to-black hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize">
                                                {{ $file->pivot->mediable_type::find($file->pivot->mediable_id)->name }}
                                            </span>
                                        </x-button>
                                    @elseif($file->pivot->mediable_type == 'App\Models\Document\Document')
                                        @php
                                            $document = $file->pivot->mediable_type::find($file->pivot->mediable_id);
                                        @endphp
                                        @if($document->type == 'invoice' || $document->type == 'bill')
                                            <x-link
                                                class="py-1.5 mb-3 sm:mb-0 text-xs bg-transparent hover:bg-transparent font-medium leading-6"
                                                override="class"
                                                href="{{ route($document->type . 's.show', $file->pivot->mediable_id) }}"
                                            >
                                                <span class="to-black hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize">
                                                    {{ $document->document_number }}
                                                </span>
                                            </x-link>
                                        @endif
                                    @elseif($file->pivot->mediable_type == 'App\Models\Banking\Transaction')
                                        @php
                                            $transaction = $file->pivot->mediable_type::find($file->pivot->mediable_id);
                                        @endphp
                                        <x-link
                                            class="py-1.5 mb-3 sm:mb-0 text-xs bg-transparent hover:bg-transparent font-medium leading-6"
                                            override="class"
                                            href="{{ route('transactions.show', $file->pivot->mediable_id) }}"
                                        >
                                            <span class="to-black hover:bg-full-2 bg-no-repeat bg-0-2 bg-0-full bg-gradient-to-b from-transparent transition-backgroundSize">
                                                {{ $transaction->number }}
                                            </span>
                                        </x-link>
                                    @endif
                                </x-slot>
                            </x-table.td>

                            <x-table.td class="w-2/12" kind="right">
                                {{ $file->created_at->diffForHumans() }}
                            </x-table.td>

                            <x-table.td kind="action">
                                @can('delete-common-uploads')
                                    <div class="absolute ltr:right-12 rtl:left-12 -top-4 hidden items-center group-hover:flex">
                                        <button
                                            type="button"
                                            id="remove-attachment"
                                            class="relative bg-white hover:bg-gray-100 border py-0.5 px-1 cursor-pointer index-actions group/tooltip"
                                            @click="onDeleteFile(
                                                '{{ $file->id }}',
                                                '{{ route('uploads.destroy', $file->id) }}',
                                                '{{ trans('general.title.delete', ['type' => 'attachment']) }}',
                                                '{{ trans('general.delete_confirm', ['name' => $file->basename, 'type' => 'attachment']) }} ',
                                                '{{ trans('general.cancel') }}',
                                                '{{ trans('general.delete') }}'
                                            )">
                                            <span class="material-icons-outlined text-purple text-lg pointer-events-none">delete</span>

                                            <div class="inline-block absolute invisible z-20 py-1 px-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 shadow-sm whitespace-nowrap opacity-0 -top-10 -left-2 group-hover/tooltip:opacity-100 group-hover/tooltip:visible" data-tooltip-placement="top">
                                                <span>{{ trans('general.delete') }}</span>
                                                <div class="absolute w-2 h-2 -bottom-1 before:content-[' '] before:absolute before:w-2 before:h-2 before:bg-white before:border-gray-200 before:transform before:rotate-45 before:border before:border-t-0 before:border-l-0" data-popper-arrow></div>
                                            </div>
                                        </button>
                                    </div>
                                @endcan
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.tbody>
            </x-table>

            {{-- <x-pagination :items="$attachments" /> --}}
        </div>
    @endif
</x-form>
