<div class="form-group {{ $errors->has('warning_before') ? ' has-error' : '' }}">
    {{ Form::label('warning_before', trans('admin/warnings/table.warning_before'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-5 {{  (\App\Helpers\Helper::checkIfRequired($item, 'warning_before')) ? ' required' : '' }}">
    {{Form::text('warning_before', Input::old('warning_before', $item->warning_before), ['class' => 'form-control', 'placeholder' => 'Enter alert before (days)'], array('class' => 'form-control')) }}
        {!! $errors->first('warning_before', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>