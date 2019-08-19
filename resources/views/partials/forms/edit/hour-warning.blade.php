  <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
  <script src="/datetimepicker/jquery.js"></script>
  <script src="/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>

<div class="form-group {{ $errors->has('hour_warning') ? ' has-error' : '' }}">
    {{ Form::label('hour_warning', trans('admin/warnings/table.hour_warning'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-5 {{  (\App\Helpers\Helper::checkIfRequired($item, 'hour_warning')) ? ' required' : '' }}">
    {{Form::text('hour_warning', Input::old('hour_warning', $item->hour_warning), ['id' => 'datetimepicker', 'class' => 'form-control', 'placeholder' => 'Enter alert hour (hours)'], array('class' => 'form-control')) }}
        {!! $errors->first('hour_warning', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>
<script>
	jQuery('#datetimepicker').datetimepicker({
		datepicker:false,
		format:'H:i'
	});
</script>