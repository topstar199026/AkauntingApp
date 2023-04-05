{!! Form::open([
    'id' => 'form-create-year',
    'route' => 'leaves.modals.settings.years.store',
    '@submit.prevent' => 'onSubmit',
    '@keydown' => 'form.errors.clear($event.target.name)',
    'files' => true,
    'role' => 'form',
    'class' => 'form-loading-button needs-validation',
    'novalidate' => 'true'
]) !!}
<div class="row">
    {{ Form::textGroup('name', trans('general.name'), 'font') }}

    {{ Form::dateGroup('start_date', trans('leaves::years.start_date'), null, ['id' => 'start_date', 'class' => 'form-control datepicker', 'required' => 'required', 'show-date-format' => company_date_format(), 'date-format' => 'Y-m-d', 'autocomplete' => 'off'], null) }}

    {{ Form::dateGroup('end_date', trans('leaves::years.end_date'), null, ['id' => 'end_date', 'class' => 'form-control datepicker', 'required' => 'required', 'show-date-format' => company_date_format(), 'date-format' => 'Y-m-d', 'autocomplete' => 'off'], null) }}
</div>
{!! Form::close() !!}
