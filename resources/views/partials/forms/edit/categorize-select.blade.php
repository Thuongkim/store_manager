<!-- Company -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, trans('admin/contract/general.categorize'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="categorizes" data-placeholder="{{ trans('admin/contract/general.categorize') }}" name="{{ $fieldname }}" style="width: 100%" id="customer_select">
            @if ($categorize = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $categorize }}" selected="selected">
                    {{ (\App\Models\Categorize::find($categorize)) ? \App\Models\Categorize::find($categorize)->name : '' }}
                </option>
            @else
                <option value="">{{ trans('admin/contract/general.categorize') }}</option>
            @endif
        </select>
    </div>


    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
