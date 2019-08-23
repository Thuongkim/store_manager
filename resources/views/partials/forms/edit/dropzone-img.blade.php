<div class="form-group">
  <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
  <div class="col-md-7">

    <div class="dropzone" id="dropzone" item_id = {{ $item->id }}>
        <div class="dz-preview dz-file-preview">
          <div class="dz-details">
            <div class="dz-filename"><span data-dz-name></span></div>
            <div class="dz-size" data-dz-size></div>
            <img data-dz-thumbnail />
          </div>
        </div>
      </div>
    
  </div>
  <div class="col-md-4 col-md-offset-3">
    <img id="imagePreview" style="max-width: 200px;">
  </div>
</div>