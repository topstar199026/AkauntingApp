<div class="my-5">
    <div class="ml-4">
        <ol class="relative border-l border-gray-200 dark:border-gray-700">
            @foreach($activities as $activity)
                <li class="mb-6 ml-6 pl-4 pt-4">
                    <span class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-gray-300 rounded-full ring-8 ring-transparent">
                        <span class="material-icons-outlined text-lg">
                            {{ $activity->getIcon() }}
                        </span>
                    </span>
                    <div class="flex items-center justify-between">
                        <h3 class="mb-2 w-10/12">
                            {{ $activity->description }}
                        </h3>
                        <time class="ltr:pl-6 rtl:pr-6 ltr:text-right rtl:text-left w-2/12 block ml-5 mb-2 text-sm font-normal leading-none">
                            {{ $activity->created_at->diffForHumans() }}
                        </time>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</div>

<x-pagination :items="$activities" />
