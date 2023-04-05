@php
    $is_portal = user()->isCustomer() ? 'portal.' : '';
@endphp
<x-form id="form-create-comments" method="POST" :route="[$is_portal . 'projects.comments.store', [(int) $models->project->id, $models->discussion->id]]">
    <div class="w-full h-40 overflow-auto mb-6">
        <p>{{ $models->discussion->description }}</p>
    </div>

    <div class="flex items-center space-x-4 border-b pb-5">
        <x-button
            id="like_button"
            class="flex items-center space-x-2 px-3 py-1.5 mb-3 sm:mb-0 rounded-xl text-sm font-medium leading-6 bg-gray-100"
            override="class"
            @click="onLike('{{ route($is_portal . 'projects.discussions.like', [$models->project, $models->discussion]) }}')"
        >
            <x-icon icon="thumb_up" /><span>{{ $models->discussion->likes->count() }}</span>
        </x-button>
    </div>

    @if(count($models->discussion->comments))
        <div class="border-b pb-5">
            <h4 class="h-18 text-base font-medium pt-5 pb-5 flex justify-start">
                {{ $models->discussion->comments->count() }}
                {{ trans_choice('projects::general.comments', 2) }}
                {{-- px-2.5 py-1 text-xs font-medium rounded-xl bg-status-danger text-text-status-danger --}}
                {{-- <div class="ml-5 mb-5 w-10 h-8 py-1 px-4 bg-blue-400 rounded-br-3xl rounded-tl-3xl rounded-tr-2xl text-white">
                    {{ $models->discussion->comments->count() }}
                </div> --}}
            </h4>
            @foreach ($models->discussion->comments as $comment)
                <div class="flex items-center justify-between">
                    <div class="mb-5 flex items-start w-10/12">
                        @php $user = $comment->user; @endphp
                        @if (setting('default.use_gravatar', '0') == '1')
                            <img src="{{ $user->picture }}" class="w-6 h-6 rounded-full mr-2 hidden lg:block" title="{{ $user->name }}" alt="{{ $user->name }}">
                        @elseif (is_object($user->picture))
                            <img src="{{ Storage::url($user->picture->id) }}" class="w-6 h-6 rounded-full mr-2 hidden lg:block" alt="{{ $user->name }}" title="{{ $user->name }}">
                        @else
                            <img src="{{ asset('public/img/user.svg') }}" class="w-6 h-6 rounded-full mr-2 hidden lg:block" alt="{{ $user->name }}"/>
                        @endif
                        <p>{{ $comment->comment }}</p>
                    </div>

                    <time class="ltr:pl-6 rtl:pr-6 ltr:text-right rtl:text-left w-2/12 block mb-2 text-sm font-normal leading-none">
                        {{ $comment->created_at->diffForHumans() }}
                    </time>
                    {{-- @if($comment->user->id === user()->id)
                        <div class="space-x-4">
                            <x-button @click="editComment()"><x-icon icon="edit" /></x-button>
                            <x-button @click="deleteComment('{{ route('projects.comments.destroy', [$models->project->id, $models->discussion->id, $comment->id]) }}')">><x-icon icon="delete" /></x-button>
                        </div>
                    @endif --}}
                </div>
            @endforeach
        </div>
    @endif

    <div class="grid sm:grid-cols-6 gap-x-8 gap-y-6 my-3.5">
        <h4 class="text-base font-medium sm:col-span-6">{{ trans('general.title.new', ['type' => trans_choice('projects::general.comments', 1)]) }}</h4>
        <x-form.group.textarea
            name="comment"
            :label="trans_choice('projects::general.comments', 1)"
        />
    </div>
</x-form>
