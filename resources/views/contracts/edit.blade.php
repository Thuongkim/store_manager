@extends('layouts/edit-form', [
  'createText' => trans('admin/contract/general.create') ,
  'updateText' => trans('admin/contract/general.update'),
  'helpTitle' => trans('admin/contract/general.about_contract_title'),
  'helpText' => trans('admin/contract/general.about_contract_text'),
  'formAction' => ($item) ? route('contract.update', ['contract' => $item->id]) : route('contract.store'),
  ])
  {{-- Page content --}}
  @section('inputFields')
  <!--Name-->
  <div class="form-group">
   <label for="number" class="col-md-3 control-label">{{ trans('admin/contract/general.number') }}</label>
   <div class="col-md-7 col-sm-12">
     <input class="form-control" type="text" name="number" id="number" value="{{ $item->number }}" />
     {!! $errors->first('number', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
   </div>
 </div>
 <!-- Sign Date -->
 <div class="form-group">
   <label for="sign_date" class="col-md-3 control-label">{{ trans('admin/contract/general.sign_date') }}</label>
   <div class="input-group col-md-5">
    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
      <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="sign_day" id="sign_day" value="{{ $item->sign_day }}">
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    </div>
    {!! $errors->first('sign_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
  </div>
</div>
<!-- Customers -->
@include ('partials.forms.edit.customer-select', ['translated_name' => trans('admin/contract/general.customer'), 'fieldname' => 'customer_id'])

<!-- Categorize -->
@include ('partials.forms.edit.categorize-select', ['translated_name' => trans('general.company'), 'fieldname' => 'categorize_id'])

<!-- Duration -->
<div class="form-group">
 <label for="duration" class="col-md-3 control-label">{{ trans('admin/contract/general.duration') }}</label>
 <div class="col-md-9 col-sm-12">
   <div class="input-group col-md-5" style="padding-left: 0px;">
     <input class="form-control" type="text" name="duration" id="duration" value="{{ Input::old('duration', $item->duration ) }}" />
     <span class="input-group-addon">
          Months
      </span>
    </div>
    <div class="col-md-9" style="padding-left: 0px;">
      {!! $errors->first('duration', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
 </div>
</div>

<!-- Renewed -->
<div class="form-group {{ $errors->has('renewed') ? ' has-error' : '' }}">
  <label for="renewed" class="col-md-3 control-label">{{ trans('admin/contract/general.renewed') }}</label>
  <div class="checkbox col-md-7">
    {{ Form::Checkbox('renewed', '1', Input::old('renewed', $item->renewed),array('class' => 'minimal')) }}
    {{ trans('general.yes') }}
  </div>
</div>

<!-- Value -->
<div class="form-group {{ $errors->has('value') ? ' has-error' : '' }}">
  <label for="value" class="col-md-3 control-label">{{ trans('admin/contract/general.value') }}</label>
  <div class="col-md-9">
    <div class="input-group col-md-5" style="padding-left: 0px;">
      <input class="form-control" type="text" name="value" id="value" value="{{ Input::old('value', \App\Helpers\Helper::formatCurrencyOutput($item->value)) }}" />
      <span class="input-group-addon">
        VND
      </span>
    </div>
    <div class="col-md-9" style="padding-left: 0px;">
      {!! $errors->first('value', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
  </div>

</div>


<!-- Payment on Checkin -->
<div class="form-group">
  {{ Form::label('payment', trans('admin/contract/general.payment'), array('class' => 'col-md-3 control-label')) }}
  <div class="col-md-9">
    {{ Form::radio('payment', '1', Input::old('payment', $item->payment) == '1', ['class'=>'minimal']) }}
    {{ 'Cash' }}
    {{ Form::radio('payment', '0', Input::old('payment', $item->payment) == '0', ['class'=>'minimal']) }}
    {{ 'Transfer' }}
    {!! $errors->first('payment', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
  </div>
</div>

<!-- Payment Date -->
<div class="form-group">
 <label for="day_payment" class="col-md-3 control-label">{{ trans('admin/contract/general.payment_date') }}</label>
 <div class="input-group col-md-5">
  <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
    <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="day_payment" id="day_payment" value="{{ $item->day_payment }}">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
  </div>
  {!! $errors->first('payment_day', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
</div>
</div>

<!-- Note -->
<div class="form-group ">
  <label for="note" class="col-md-3 control-label">{{ trans('admin/contract/general.note') }}</label>
  <div class="col-md-7 col-sm-12">
    <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $item->note) }}</textarea>
    {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
  </div>
</div>
<!-- Sale -->
@include ('partials.forms.edit.sale-select', ['translated_name' => trans('general.company'), 'fieldname' => 'sale_id'])
<!-- Image -->

@include ('partials.forms.edit.dropzone-img')

@stop

@section('dropzone-img')
<script>
  // Disable auto discover for all elements:
  Dropzone.autoDiscover = false;
  var myDropzone = new Dropzone("div#dropzone", { 
    url: "{{ route('dropzone.store') }}", 
    headers: { 'X-CSRF-TOKEN': '{!! csrf_token() !!}' },
    acceptedFiles: "image/*,application/pdf",
    maxFilesize: 4, // MB
    init: function() {
      this.on("thumbnail", function() {
            $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
        });
      this.on("success", function(file, response) {
          file.imageId = response.id;
          // console.log(file.imageId);
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
                  url: "{{ route('dropzone.delete') }}",
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
     $.getJSON("{{ route('show.dropzone') }}?id="+ thisDropzone.element.attributes.item_id.value).done(function(response) {
          var data = response.data;
          $.each(data, function (index, item) {
                  // console.log(item);
                  var mockFile = {
                      imageId: item.id,
                      name: item.url
                  };
                  // Call the default addedfile event handler
                  thisDropzone.emit("addedfile", mockFile);

                  // And optionally show the thumbnail of the file
                  var ext = item.url.split('.').pop();
                  if (ext == "pdf") {
                      thisDropzone.emit("thumbnail", mockFile, "https://" + window.location.hostname +'/uploads/contract/pdf.png');
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
@endsection

