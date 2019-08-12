@extends('layouts/edit-form', [
    'createText' => trans('admin/sales/general.create') ,
    'updateText' => trans('admin/sales/general.update'),
    'helpTitle' => trans('admin/sales/general.about_sales_title'),
    'helpText' => trans('admin/sales/general.about_sales_text'),
    'formAction' => ($item) ? route('sales.update', ['sale' => $item->id]) : route('sales.store'),
])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/sales/general.sale_name')])
@include ('partials.forms.edit.email')
@include ('partials.forms.edit.phone')
@include ('partials.forms.edit.address_sale')

<!-- Genders on Checkin -->
<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    {{ Form::label('gender', trans('admin/sales/general.gender'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-9">
        {{ Form::radio('gender', '1', Input::old('gender', $item->gender) == '1', ['class'=>'minimal']) }}
        {{ 'Male' }}
        {{ Form::radio('gender', '0', Input::old('gender', $item->gender) == '0', ['class'=>'minimal']) }}
        {{ 'Female' }}
        {!! $errors->first('gender', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<!-- Image -->
@if ($item->image)
    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
        <div class="col-md-5">
            {{ Form::checkbox('image_delete') }}
            <img src="{{ url('/') }}/uploads/accessories/{{ $item->image }}" />
            {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
        </div>
    </div>
@endif


@stop
