<div class="form-group {{ $errors->has('duration') ? ' has-error' : '' }}">
    {{ Form::label('duration', trans('admin/customers/table.duration'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-4 {{  (\App\Helpers\Helper::checkIfRequired($item, 'name')) ? ' required' : '' }}">
    {{Form::text('duration', Input::old('duration', $item->duration), array('class' => 'form-control')) }}
        {!! $errors->first('duration', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>