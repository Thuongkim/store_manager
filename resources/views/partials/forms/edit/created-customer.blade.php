<div class="form-group {{ $errors->has('created_customer_at') ? ' has-error' : '' }}">
    {{ Form::label('created_customer_at', trans('admin/warnings/table.created_customer'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-4">
    	<label style="font-size: 15px; border-radius: 15px !important" id="lb" class="label label-info">{{ isset($item->created_customer_at) ? ($item->created_customer_at) : "Please select a customer name !!" }}</label>
        {!! $errors->first('created_customer_at', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>