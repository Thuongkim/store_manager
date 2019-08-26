<!-- Company -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, trans('admin/contract/general.sale'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="sales" data-placeholder="{{ trans('admin/contract/general.sale') }}" name="{{ $fieldname }}" style="width: 100%" id="customer_select">
            @if ($sales = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $sales }}" selected="selected">
                    {{ (\App\Models\Sale::find($sales)) ? \App\Models\Sale::find($sales)->name : '' }}
                </option>
            @else
                <option value="">{{ trans('admin/contract/general.sale') }}</option>
            @endif
        </select>
    </div>


    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
