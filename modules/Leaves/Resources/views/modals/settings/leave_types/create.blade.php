{!! Form::open([
    'id' => 'form-create-leave-type',
    'route' => 'leaves.modals.settings.leave-types.store',
    '@submit.prevent' => 'onSubmit',
    '@keydown' => 'form.errors.clear($event.target.name)',
    'files' => true,
    'role' => 'form',
    'class' => 'form-loading-button needs-validation',
    'novalidate' => 'true'
]) !!}
<div class="row">
    {{ Form::textGroup('name', trans('general.name'), 'font') }}

    {{ Form::textareaGroup('description', trans('general.description'), '', null, ['rows' => '3']) }}
</div>
{!! Form::close() !!}
