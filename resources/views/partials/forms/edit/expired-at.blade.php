<div class="form-group {{ $errors->has('expired_at') ? ' has-error' : '' }}">
    {{ Form::label('expired_at', trans('admin/warnings/table.expired_at'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-4">
    	<label style="font-size: 15px; border-radius: 15px !important" id="ex" class="label label-primary">{{ isset($item->expired_at) ? ($item->expired_at) : "You do not need to fill in this" }}</label>
        {!! $errors->first('expired_at', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>