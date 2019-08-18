<div class="form-group {{ $errors->has('province') ? ' has-error' : '' }}">
    {{ Form::label('province', trans('admin/customers/table.province'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7 {{  (\App\Helpers\Helper::checkIfRequired($item, 'name')) ? ' required' : '' }}">
    {{Form::text('province', Input::old('phone', $item->province), array('class' => 'form-control')) }}
        {!! $errors->first('province', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>