@section('title', $class->model->name)

@section('new_button')
    @if ($class->model->id)
        <a href="{{ url($class->getUrl('print')) }}" target="_blank" class="btn btn-primary btn-sm">
            {{ trans('general.print') }}
        </a>
    @else
        <a href="{{ route('budgets.index') }}" class="btn btn-white btn-sm">
            {{ trans('modules.back') }}
        </a>
    @endif
@endsection
