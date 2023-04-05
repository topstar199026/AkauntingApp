<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('helpdesk::general.tickets', 1) . ' ' . $ticket->name }}
    </x-slot>

    <x-slot name="favorite" title="{{ $ticket->name }}" icon="confirmation_number" :route="['helpdesk.tickets.show', $ticket->id]"></x-slot>

    <x-slot name="buttons">
        @if ($ticket->status_id == $last_status_id)
            <button type="button"
                class="flex items-center px-3 py-1.5 mb-3 sm:mb-0 bg-green rounded-xl text-white text-sm font-bold leading-6 cursor-not-allowed">
                {{ strtoupper($ticket->statuses[$ticket->status_id]) }}
            </button>
        @else
            <x-dropdown id="dropdown-ticket-statuses">
                @if ($ticket->status_id == $first_status_id)
                    <x-slot name="trigger"
                        class="flex items-center px-3 py-1.5 mb-3 sm:mb-0 bg-red-600 hover:bg-red-800 rounded-xl text-white text-sm font-bold leading-6"
                        override="class">
                        {{ strtoupper($ticket->statuses[$ticket->status_id]) }}
                        <span class="material-icons ltr:ml-2 rtl:mr-2">expand_more</span>
                    </x-slot>
                @else
                    <x-slot name="trigger"
                        class="flex items-center px-3 py-1.5 mb-3 sm:mb-0 bg-purple hover:bg-purple-700 rounded-xl text-white text-sm font-bold leading-6"
                        override="class">
                        {{ strtoupper($ticket->statuses[$ticket->status_id]) }}
                        <span class="material-icons ltr:ml-2 rtl:mr-2">expand_more</span>
                    </x-slot>
                @endif

                @foreach ($statuses as $status_id => $status)
                    @if ($ticket->status_id == $status_id)
                        @continue
                    @else
                        <x-dropdown.link @click="onTicketUpdate({{ $ticket->id }}, {{ $status_id }})">
                            {{ strtoupper($status) }}
                        </x-dropdown.link>
                    @endif
                @endforeach
            </x-dropdown>
        @endif

        @can('create-helpdesk-tickets')
            <x-link href="{{ route('helpdesk.tickets.create') }}" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('helpdesk::general.tickets', 1)]) }}
            </x-link>
        @endcan

        @can('update-helpdesk-tickets')
            <x-link href="{{ route('helpdesk.tickets.edit', $ticket->id) }}">
                {{ trans('general.edit') }}
            </x-link>
        @endcan

        <x-dropdown id="dropdown-actions">
            <x-slot name="trigger">
                <span class="material-icons">more_horiz</span>
            </x-slot>

            @can('delete-helpdesk-tickets')
                <x-delete-link :model="$ticket" route="helpdesk.tickets.destroy" />
            @endcan
        </x-dropdown>
    </x-slot>

    <x-slot name="content">
        <x-show.container>
            <x-show.summary>
                <div class="flex flex-col text-base mb-5">
                    <span class="text-xl mb-5">{{ $ticket->subject }}</span>
                    <div class="font-medium">{{ trans('helpdesk::general.ticket.message') }}</div>
                    <span class="mb-5">{!! nl2br($ticket->message) !!}</span>

                    @if ($ticket->attachment)
                        <div class="justify-start pb-4" x-data="{ attachment: null }">
                            <div class="relative w-full text-left cursor-pointer group"
                                x-on:click="attachment !== 1 ? attachment = 1 : attachment = null">
                                <span
                                    class="font-medium border-b border-transparent transition-all group-hover:border-black">
                                    {{ trans_choice('general.attachments', 2) }}
                                </span>

                                <div class="text-black-400 text-sm">{{ trans('helpdesk::general.download') }}</div>

                                <span class="material-icons absolute right-0 top-0 transition-all transform"
                                    x-bind:class="attachment === 1 ? 'rotate-180' : ''">expand_more</span>
                            </div>

                            <div class="relative overflow-hidden transition-all max-h-0 duration-700" style=""
                                x-ref="container1"
                                x-bind:style="attachment == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                                @foreach ($ticket->attachment as $file)
                                    <x-media.file :file="$file" />
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </x-show.summary>

            <x-show.content>
                <x-show.content.left>
                    <div class="flex flex-col text-sm mb-5">
                        <div class="font-medium">{{ trans('helpdesk::general.ticket.created') }}</div>
                        <x-date date="{{ $ticket->created_at }}" />{{ $ticket->created_at->format('H:i') }}
                    </div>

                    <div class="flex flex-col text-sm mb-5">
                        <div class="font-medium">{{ trans('helpdesk::general.ticket.updated') }}</div>
                        <x-date date="{{ $ticket->updated_at }}" />{{ $ticket->updated_at->format('H:i') }}
                    </div>

                    <div class="flex flex-col text-sm mb-5">
                        <div class="font-medium">{{ trans('helpdesk::general.ticket.reporter') }}</div>
                        <span>{{ $ticket->owner->name }}</span>
                    </div>

                    <x-show.accordion type="assignee" :open="false" class="border-none">
                        <x-slot name="head">
                            <!-- x-show.accordion head -->
                            <div>
                                <div class="text-sm font-medium text-black">
                                    <x-button.hover group-hover>
                                        {{ trans('helpdesk::general.ticket.assignee') }}
                                    </x-button.hover>
                                </div>

                                <span class="text-sm text-black">
                                    {{ $ticket->assignee->name }}
                                </span>
                            </div>
                        </x-slot>

                        <x-slot name="body">
                            <!-- x-show.accordion body -->
                            <div class="flex">
                                <x-link href="javascript:;" @click="onAssigneeUpdateModalOpen">
                                    {{ trans('general.edit') }}
                                </x-link>
                            </div>
                        </x-slot>
                    </x-show.accordion>

                    <div class="flex flex-col text-sm mb-5">
                        <div class="font-medium">{{ trans_choice('general.categories', 1) }}</div>
                        <span>{{ $ticket->category->name }}</span>
                    </div>

                    <x-show.accordion type="assignee" :open="false" class="border-none">
                        <x-slot name="head">
                            <!-- x-show.accordion head -->
                            <div>
                                <div class="text-sm font-medium text-black">
                                    <x-button.hover group-hover>
                                        {{ trans_choice('helpdesk::general.priorities', 1) }}
                                    </x-button.hover>
                                </div>

                                <span class="text-sm text-black">
                                    {{ $ticket->priority->name }}
                                </span>
                            </div>
                        </x-slot>

                        <x-slot name="body">
                            <!-- x-show.accordion body -->
                            <div class="flex">
                                <x-link href="javascript:;" @click="onPriorityUpdateModalOpen">
                                    {{ trans('general.edit') }}
                                </x-link>
                            </div>
                        </x-slot>
                    </x-show.accordion>

                    <div class="flex flex-col text-sm mb-5">
                        @if (count($ticket->documents))
                            <div class="font-medium">{{ trans('helpdesk::general.ticket.related_to') }}</div>
                            <span>
                                @foreach ($ticket->documents as $document)
                                    <a class="border-black border-b border-dashed"
                                        href="{{ route($document->document->type == 'invoice' ? 'invoices.show' : 'bills.show', $document->document->id) }}">
                                        {{ $document->document->document_number }}
                                    </a><br>
                                @endforeach
                            </span>
                        @else
                            <div class="font-medium">{{ trans('helpdesk::general.ticket.not_related') }}</div>
                        @endif
                    </div>
                </x-show.content.left>

                <x-show.content.right>
                    <div class="w-12/12">
                        <div class="flex">
                            <h3 class="flex-1 text-left">{{ trans_choice('helpdesk::general.replies', 2) }}</h3>
                            <x-link href="javascript:;" kind="secondary"
                                @click="onReplyCreateModalOpen({{ $ticket->id }}, $event)">
                                {{ trans('helpdesk::general.reply.new_reply') }}
                            </x-link>
                        </div>

                        <x-table>
                            <x-table.thead>
                                <x-table.tr class="flex items-center px-1">
                                    <x-table.th class="w-3/12">
                                        <x-slot name="first">
                                            <x-sortablelink column="user"
                                                title="{{ trans_choice('general.users', 1) }}" :arguments="['class' => 'col-aka', 'rel' => 'nofollow']" />
                                        </x-slot>
                                        <x-slot name="second">
                                            <x-sortablelink column="created_at"
                                                title="{{ trans('general.created') }}" />
                                        </x-slot>
                                    </x-table.th>

                                    <x-table.th class="w-1/12"></x-table.th>

                                    <x-table.th class="w-8/12">
                                        <x-sortablelink column="description"
                                            title="{{ trans('helpdesk::general.ticket.message') }}" />
                                    </x-table.th>
                                </x-table.tr>
                            </x-table.thead>

                            <x-table.tbody>
                                @foreach ($replies as $reply)
                                    <x-table.tr href="javascript:;" data-table-list
                                        class="relative flex items-center border-b hover:bg-gray-100 px-1 group">
                                        <x-table.td class="w-3/12 truncate">
                                            <x-slot name="first">
                                                {{ $reply->owner->name }}
                                            </x-slot>
                                            <x-slot name="second">
                                                <x-date date="{{ $reply->created_at }}" />
                                            </x-slot>
                                        </x-table.td>

                                        <x-table.td class="w-1/12 truncate">
                                            <div>
                                                @if ($reply->internal)
                                                    <span class="material-icons-outlined text-lg">lock</span>
                                                @endif
                                            </div>
                                        </x-table.td>

                                        <x-table.td class="w-8/12">
                                            <div class="whitespace-normal">
                                                {{ $reply->message }}
                                            </div>
                                        </x-table.td>

                                        @can(['update-helpdesk-replies', 'delete-helpdesk-replies'])
                                            <x-table.td kind="action" class="p-0" override="class">
                                                <x-table.actions :model="$reply" />
                                            </x-table.td>
                                        @endcan

                                    </x-table.tr>
                                @endforeach
                            </x-table.tbody>
                        </x-table>

                        <x-pagination :items="$replies" />
                    </div>
                </x-show.content.right>
            </x-show.content>
        </x-show.container>

        @push('content_content_end')
            <akaunting-modal :show="create_reply.modal" @cancel="create_reply.modal = false"
                :title="'{{ trans('helpdesk::general.reply.new_reply') }}'" :message="create_reply.html"
                :button_cancel="'{{ trans('general.button.save') }}'"
                :button_delete="'{{ trans('general.button.cancel') }}'">
                <template #modal-body>
                    @include('helpdesk::modals.replies.create')
                </template>

                <template #card-footer>
                    <div class="flex items-center justify-end">
                        <button type="button" class="px-6 py-1.5 hover:bg-gray-200 rounded-lg ltr:mr-2 rtl:ml-2"
                            @click="closeReplyCreateModal">
                            {{ trans('general.cancel') }}
                        </button>

                        <button :disabled="create_reply_form.loading" type="button"
                            class="relative flex items-center justify-center bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
                            @click="onReplyCreate">
                            <i v-if="create_reply_form.loading"
                                class="animate-submit delay-[0.28s] absolute w-2 h-2 rounded-full left-0 right-0 -top-3.5 m-auto before:absolute before:w-2 before:h-2 before:rounded-full before:animate-submit before:delay-[0.14s] after:absolute after:w-2 after:h-2 after:rounded-full after:animate-submit before:-left-3.5 after:-right-3.5 after:delay-[0.42s]"></i>
                            <span
                                :class="[{ 'opacity-0': create_reply_form.loading }]">{{ trans('general.confirm') }}</span>
                        </button>
                    </div>
                </template>
            </akaunting-modal>

            <akaunting-modal :show="update_reply.modal" @cancel="update_reply.modal = false"
                :title="'{{ trans('general.edit') }}'" :message="update_reply.html"
                :button_cancel="'{{ trans('general.button.save') }}'"
                :button_delete="'{{ trans('general.button.cancel') }}'">
                <template #modal-body>
                    @include('helpdesk::modals.replies.update')
                </template>

                <template #card-footer>
                    <div class="flex items-center justify-end">
                        <button type="button" class="px-6 py-1.5 hover:bg-gray-200 rounded-lg ltr:mr-2 rtl:ml-2"
                            @click="closeReplyEditModal">
                            {{ trans('general.cancel') }}
                        </button>

                        <button :disabled="update_reply_form.loading" type="button"
                            class="relative flex items-center justify-center bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
                            @click="onReplyEdit">
                            <i v-if="create_reply_form.loading"
                                class="animate-submit delay-[0.28s] absolute w-2 h-2 rounded-full left-0 right-0 -top-3.5 m-auto before:absolute before:w-2 before:h-2 before:rounded-full before:animate-submit before:delay-[0.14s] after:absolute after:w-2 after:h-2 after:rounded-full after:animate-submit before:-left-3.5 after:-right-3.5 after:delay-[0.42s]"></i>
                            <span
                                :class="[{ 'opacity-0': update_reply_form.loading }]">{{ trans('general.confirm') }}</span>
                        </button>
                    </div>
                </template>
            </akaunting-modal>

            <akaunting-modal :show="update_priority.modal" @cancel="update_priority.modal = false"
                :title="'{{ trans('general.edit') }}'" :message="update_priority.html"
                :button_cancel="'{{ trans('general.button.save') }}'"
                :button_delete="'{{ trans('general.button.cancel') }}'">
                <template #modal-body>
                    @include('helpdesk::modals.tickets.update_priority')
                </template>

                <template #card-footer>
                    <div class="flex items-center justify-end">
                        <button type="button" class="px-6 py-1.5 hover:bg-gray-200 rounded-lg ltr:mr-2 rtl:ml-2"
                            @click="closePriorityUpdateModal">
                            {{ trans('general.cancel') }}
                        </button>

                        <button :disabled="update_priority_form.loading" type="button"
                            class="relative flex items-center justify-center bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
                            @click="onPriorityUpdate({{ $ticket->id }})">
                            <i v-if="update_priority_form.loading"
                                class="animate-submit delay-[0.28s] absolute w-2 h-2 rounded-full left-0 right-0 -top-3.5 m-auto before:absolute before:w-2 before:h-2 before:rounded-full before:animate-submit before:delay-[0.14s] after:absolute after:w-2 after:h-2 after:rounded-full after:animate-submit before:-left-3.5 after:-right-3.5 after:delay-[0.42s]"></i>
                            <span
                                :class="[{ 'opacity-0': update_priority_form.loading }]">{{ trans('general.confirm') }}</span>
                        </button>
                    </div>
                </template>
            </akaunting-modal>

            <akaunting-modal :show="update_assignee.modal" @cancel="update_assignee.modal = false"
                :title="'{{ trans('general.edit') }}'" :message="update_assignee.html"
                :button_cancel="'{{ trans('general.button.save') }}'"
                :button_delete="'{{ trans('general.button.cancel') }}'">
                <template #modal-body>
                    @include('helpdesk::modals.tickets.update_assignee')
                </template>

                <template #card-footer>
                    <div class="flex items-center justify-end">
                        <button type="button" class="px-6 py-1.5 hover:bg-gray-200 rounded-lg ltr:mr-2 rtl:ml-2"
                            @click="closeAssigneeUpdateModal">
                            {{ trans('general.cancel') }}
                        </button>

                        <button :disabled="update_assignee_form.loading" type="button"
                            class="relative flex items-center justify-center bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
                            @click="onAssigneeUpdate({{ $ticket->id }})">
                            <i v-if="update_priority_form.loading"
                                class="animate-submit delay-[0.28s] absolute w-2 h-2 rounded-full left-0 right-0 -top-3.5 m-auto before:absolute before:w-2 before:h-2 before:rounded-full before:animate-submit before:delay-[0.14s] after:absolute after:w-2 after:h-2 after:rounded-full after:animate-submit before:-left-3.5 after:-right-3.5 after:delay-[0.42s]"></i>
                            <span
                                :class="[{ 'opacity-0': update_assignee_form.loading }]">{{ trans('general.confirm') }}</span>
                        </button>
                    </div>
                </template>
            </akaunting-modal>
        @endpush

    </x-slot>

    <x-script alias="helpdesk" file="tickets" />
</x-layouts.admin>
