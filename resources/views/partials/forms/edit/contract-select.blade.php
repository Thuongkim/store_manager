<!-- contract -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="contracts" data-placeholder="{{ trans('general.contract') }}" name="{{ $fieldname }}" style="width: 100%" id="contract_select">
            @if ($contract_id = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $contract_id }}" selected="selected">
                    {{ (\App\Models\Contract::find($contract_id)) ? \App\Models\Contract::find($contract_id)->number : '' }}
                </option>
            @else
                <option value="">{{ trans('general.select_contract') }}</option>
            @endif
        </select>
    </div>


    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
