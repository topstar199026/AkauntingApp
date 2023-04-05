<x-layouts.admin>
    <x-slot name="title">
        {{ $class->model->name }}
    </x-slot>

    <x-slot name="buttons">
        @if ($class->model->id)
            <x-link href="{{ url($class->getUrl('print')) }}" target="_blank">
                {{ trans('general.print') }}
            </x-link>
        @else
            <x-link href="{{ route('budgets.index') }}">
                {{ trans('modules.back') }}
            </x-link>
        @endif
    </x-slot>

    <x-slot name="content">
        <div class="my-10">
            @include($class->views['filter'])

            @include($class->views[$class->type])
        </div>
    </x-slot>
</x-layouts.admin>
