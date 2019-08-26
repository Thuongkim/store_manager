<div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
    {{ Form::label('status', trans('admin/warnings/table.status'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-4">
    	<label style="font-size: 13px; border-radius: 15px !important" id="stt" class="label label-{{ ($item->status == 'Active') ? 'info' : 'default' }}">{{ ($item->status) ? $item->status : "You do not need to fill in this" }}</label>
    	<?php
    		if($item->status == 'Active')
    		{ ?>
				<i style="color: #02B301; font-size: 25px;" class="fa fa-check-circle" ></i>
    <?php	}
    		else if($item->status == 'Expired')
    		{ ?>
    			<i style="color: red; font-size: 25px; " class="fa fa-exclamation-circle" ></i>
    <?php	}
    	?>
        {!! $errors->first('status', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>