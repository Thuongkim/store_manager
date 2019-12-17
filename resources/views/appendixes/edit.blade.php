@extends('layouts/edit-form', [
    'createText' => trans('admin/appendixes/general.create') ,
    'updateText' => trans('admin/appendixes/general.update'),
    'helpTitle' => trans('admin/appendixes/general.about_appendixes_title'),
    'helpText' => trans('admin/appendixes/general.about_appendixes_text'),
    'formAction' => ($item) ? route('appendixes.update', ['appendix' => $item->id]) : route('appendixes.store'),
])

{{-- Page content --}}
@section('inputFields')
<!-- Sign Date -->
<div class="form-group {{ $errors->has('sign_date') ? ' has-error' : '' }}">
   <label for="sign_date" class="col-md-3 control-label">{{ trans('admin/appendixes/general.sign_date') }}</label>
   <div class="input-group col-md-5">
        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="sign_date" id="sign_date" value="{{ Input::old('sign_date', ($item->sign_date) ? $item->sign_date->format('Y-m-d') : '') }}">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>
       {!! $errors->first('sign_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
   </div>
</div>

<!-- Duration -->
<div class="form-group {{ $errors->has('duration') ? ' has-error' : '' }}">
   <label for="duration" class="col-md-3 control-label">{{ trans('admin/appendixes/general.duration') }}</label>
   <div class="col-md-7 col-sm-12">
       <input class="form-control" type="text" name="duration" id="duration" value="{{ Input::old('duration', $item->duration) }}" />
       {!! $errors->first('duration', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
   </div>
</div>

<!-- Renewed -->
<div class="form-group {{ $errors->has('renewed') ? ' has-error' : '' }}">
    <label for="renewed" class="col-md-3 control-label">{{ trans('admin/appendixes/general.renewed') }}</label>
    <div class="checkbox col-md-7">
        {{ Form::Checkbox('renewed', '1', Input::old('renewed', $item->renewed),array('class' => 'minimal')) }}
        {{ trans('general.yes') }}
    </div>
</div>

<!-- Value -->
<div class="form-group {{ $errors->has('value') ? ' has-error' : '' }}">
    <label for="value" class="col-md-3 control-label">{{ trans('admin/appendixes/general.value') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-3" style="padding-left: 0px;">
            <input class="form-control" type="text" name="value" id="value" value="{{ Input::old('value', \App\Helpers\Helper::formatCurrencyOutput($item->value)) }}" />
            <span class="input-group-addon">
                @if (isset($currency_type))
                    {{ $currency_type }}
                @else
                    {{ $snipeSettings->default_currency }}
                @endif
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('value', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
        </div>
    </div>

</div>


<!-- Payment on Checkin -->
<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    {{ Form::label('payment', trans('admin/appendixes/general.payment'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-9">
        {{ Form::radio('payment', '1', Input::old('payment', $item->payment) == '1', ['class'=>'minimal']) }}
        {{ 'Cash' }}
        {{ Form::radio('payment', '0', Input::old('payment', $item->payment) == '0', ['class'=>'minimal']) }}
        {{ 'Bank Tranfers' }}
        {!! $errors->first('payment', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<!-- Payment Date -->
<div class="form-group {{ $errors->has('payment_date') ? ' has-error' : '' }}">
   <label for="payment_date" class="col-md-3 control-label">{{ trans('admin/appendixes/general.payment_date') }}</label>
   <div class="input-group col-md-5">
        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="payment_date" id="payment_date" value="{{ Input::old('payment_date', ($item->payment_date) ? $item->payment_date->format('Y-m-d') : '') }}">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>
       {!! $errors->first('payment_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
   </div>
</div>

<!-- Contract id -->
@include ('partials.forms.edit.contract-select', ['translated_name' => trans('general.contract'), 'fieldname' => 'contract_id'])

<!-- Note -->
<div class="form-group {{ $errors->has('note') ? ' has-error' : '' }}">
    <label for="note" class="col-md-3 control-label">{{ trans('admin/appendixes/general.note') }}</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $item->note) }}</textarea>
        {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<!-- Image -->
@if ($item->image)
    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
        <div class="col-md-5">
            {{ Form::checkbox('image_delete') }}
            <img src="{{ url('/') }}/uploads/accessories/{{ $item->image }}" />
            {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
        </div>
    </div>
@endif

{{-- @include ('partials.forms.edit.image-upload') --}}
<div class="form-group">
  <label for="myId" class="col-md-3 control-label">{{ trans('general.image_upload') }}</label>
  <div class="col-md-9">
    <div class="dropzone" id="myId" item_id="{!! $item->id !!}"></div>
  </div>
</div>

@stop

@section('edit_scripts')
<script>
  // Disable auto discover for all elements:
  Dropzone.autoDiscover = false;
  var myDropzone = new Dropzone("div#myId", { 
    url: "/uploadImage", 
    headers: { 'X-CSRF-TOKEN': '{!! csrf_token() !!}' },
    acceptedFiles: "image/*,application/pdf",
    maxFilesize: 4, // MB
    init: function() {
      this.on("thumbnail", function() {
            $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
        });
      this.on("success", function(file, response) {
          file.imageId = response.id;
          // file.name = response.title;
          // toastr.success(response.message);
      });
      this.on("addedfile", function(file) {
          // Create the remove button
          var removeButton = Dropzone.createElement("<a class='dz-remove' href='#' data-dz-remove=''>Xóa ảnh</a>");

          // Capture the Dropzone instance as closure.
          var _this = this;

          // Listen to the click event
          removeButton.addEventListener("click", function(e) {
              // Make sure the button click doesn't submit the form:
              e.preventDefault();
              e.stopPropagation();

              // Remove the file preview.
              _this.removeFile(file);
              // If you want to the delete the file on the server as well,
              // you can do the AJAX request here.
              $.ajax({
                  url: "/deleteImage",
                  data: { imageId: file.imageId },
                  headers: { "X-CSRF-TOKEN": "{!! csrf_token() !!}" },
                  type: 'POST',
                  // success: function (data) {
                  //     toastr.success(data.message);
                  // },
                  // error: function (data) {
                  //     toastr.error(data.message);
                  // }
              });
          });

          // Add the button to the file preview element.
          file.previewElement.appendChild(removeButton);
      });

      var thisDropzone = this;
      // Call the action method to load the images from the server
     $.getJSON("{{ route('showImage') }}?id="+ thisDropzone.element.attributes.item_id.value).done(function(response) {
          var data = response.data;
          $.each(data, function (index, item) {
                  // console.log(item);
                  var mockFile = {
                      imageId: item.id
                  };

                  // Call the default addedfile event handler
                  thisDropzone.emit("addedfile", mockFile);

                  // And optionally show the thumbnail of the file
                  var ext = item.url.split('.').pop();
                  if (ext == "pdf") {
                      // thisDropzone.emit("thumbnail", mockFile, "http://" + window.location.hostname + ":" + window.location.port +"/uploads/appendixes/pdf.png");
                      thisDropzone.emit("thumbnail", mockFile, "https://" + window.location.hostname + "/uploads/appendixes/pdf.png");
                  } 
                  else {
                  thisDropzone.emit("thumbnail", mockFile, "https://" + window.location.hostname + '/' +item.url);
                  }

                  // If you use the maxFiles option, make sure you adjust it to the
                  // correct amount:
                  //var existingFileCount = 1; // The number of files already uploaded
                  //myDropzone.options.maxFiles = myDropzone.options.maxFiles - existingFileCount;
          });
          $(".dz-progress").remove();
      });
  },
  });

</script>
@stop
