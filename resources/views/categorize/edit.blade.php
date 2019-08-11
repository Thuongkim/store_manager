@extends('layouts/edit-form', [
    'createText' => trans('admin/categorize/general.create') ,
    'updateText' => trans('admin/categorize/general.update'),
    'helpTitle' =>  trans('admin/categorize/general.about_categorize_title'),
    'helpText' => trans('admin/categorize/general.about_categorize'),
    'formAction' => ($item) ? route('categorize.update', ['category' => $item->id]) : route('categorize.store'),
])

@section('inputFields')



<!-- Type -->
<div class="form-group">
    <label for="name" class="col-md-3 control-label">{{ trans('general.name') }}</label>
    <div class="col-md-7 col-sm-12">
        <input class="form-control" type="text" name="name" id="name" value="{{ $item->name }}" />
        {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<!-- EULA text -->
<div class="form-group ">
    <label for="eula_text" class="col-md-3 control-label">{{ trans('general.description') }}</label>
    <div class="col-md-7">
        {{ Form::textarea('description', Input::old('description', $item->description), array('class' => 'form-control')) }}
        {!! $errors->first('description', '<span class="alert-msg">:message</span>') !!}
    </div>
</div>




@stop
