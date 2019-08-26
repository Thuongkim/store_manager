<!-- Company -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="customers" data-placeholder="{{ trans('general.select_customer') }}" name="{{ $fieldname }}" style="width: 100%" id="customer_select">
            @if ($id_customer = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $id_customer }}" selected="selected">
                    {{ (\App\Models\Customer::find($id_customer)) ? \App\Models\Customer::find($id_customer)->name : '' }}
                </option>
            @else
                <option value="">{{ trans('general.select_customer') }}</option>
            @endif
        </select>
    </div>


    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
