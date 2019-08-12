<div class="form-group {{ $errors->has('taxcode') ? ' has-error' : '' }}">
    {{ Form::label('taxcode', trans('admin/customers/table.taxcode'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-3 {{ (\App\Helpers\Helper::checkIfRequired($item, 'name')) ? ' required' : '' }}">
    {{Form::text('taxcode', Input::old('taxcode', $item->taxcode), array('class' => 'form-control')) }}
        {!! $errors->first('taxcode', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>