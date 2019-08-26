<!-- Company -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, trans('admin/contract/general.customer'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="customers" data-placeholder="{{ trans('admin/contract/general.customer') }}" name="{{ $fieldname }}" style="width: 100%" id="customer_select">
            @if ($customer_id = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $customer_id }}" selected="selected">
                    {{ (\App\Models\Customer::find($customer_id)) ? \App\Models\Customer::find($customer_id)->name : '' }}
                </option>
            @else
                <option value="">{{ trans('admin/contract/general.customer') }}</option>
            @endif
        </select>
    </div>


    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
