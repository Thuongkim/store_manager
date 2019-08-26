@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/sales/general.view_sale').' ' . strtoupper($sale->name) }}
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs hidden-print">

        <li class="active">
          <a href="#details" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fa fa-info-circle"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('admin/users/general.info') }}</span>
          </a>
        </li>

        @can('update', $sale)
          <li class="dropdown pull-right">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-gear"></i> {{ trans('button.actions') }}
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('sales.edit', $sale->id) }}">{{ trans('admin/sales/general.edit') }}</a></li>
            </ul>
          </li>
        @endcan
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="details">
          <div class="row">
            <div class="col-md-8">
              <div class="table table-responsive">
                <table class="table table-striped">
                  @if ($sale->name)
                    <tr>
                        <td class="text-nowrap">{{ trans('general.name') }}</td>
                        <td>{{ $sale->name }}</td>
                    </tr>
                  @endif

                  @if ($sale->email)
                  <tr>
                    <td class="text-nowrap">{{ trans('admin/users/table.email') }}</td>
                    <td><a href="mailto:{{ $sale->email }}">{{ $sale->email }}</a></td>
                  </tr>
                  @endif

                  @if ($sale->phone)
                  <tr>
                    <td class="text-nowrap">{{ trans('admin/users/table.phone') }}</td>
                    <td><a href="tel:{{ $sale->phone }}">{{ $sale->phone }}</a></td>
                  </tr>
                  @endif

                  @if ($sale->address)
                    <tr>
                        <td class="text-nowrap">{{ trans('general.address') }}</td>
                        <td>{{ $sale->address }}</td>
                    </tr>
                  @endif

                  @if (isset($sale->gender))
                    <tr>
                        <td class="text-nowrap">{{ trans('admin/sales/general.gender') }}</td>
                        @if ($sale->gender == 1)
                          <td>Male</td>
                        @else 
                          <td>Female</td>
                        @endif
                    </tr>
                  @endif

                  @if ($sale->created_at)
                  <tr>
                    <td>{{ trans('general.created_at') }}</td>
                    <td>{{ $sale->created_at->format('F j, Y h:iA') }}</td>
                  </tr>
                  @endif
                </table>
              </div>
            </div> <!--/col-md-8-->

            <!-- Start button column -->
            <div class="col-md-2">
              @can('update', $sale)
                <div class="col-md-12">
                  <a href="{{ route('sales.edit', $sale->id) }}" style="width: 100%;" class="btn btn-sm btn-default hidden-print">{{ trans('admin/sales/general.edit') }}</a>
                </div>
              @endcan

              @can('delete', $sale)
              <div class="col-md-12" style="padding-top: 5px;">
                <form action="{{route('sales.destroy',$sale->id)}}" method="POST">
                  {{csrf_field()}}
                  {{ method_field("DELETE")}}
                  <button style="width: 100%;" class="btn btn-sm btn-warning hidden-print">{{ trans('button.delete')}}</button>
                </form>
              </div>
              @endcan

            </div>
            <!-- End button column -->
          </div> <!--/.row-->
        </div><!-- /.tab-pane -->
      </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->
  </div>
</div>

@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table', ['simple_view' => true])
<script nonce="{{ csrf_token() }}">
$(function () {

  $("#two_factor_reset").click(function(){
    $("#two_factor_resetrow").removeClass('success');
    $("#two_factor_resetrow").removeClass('danger');
    $("#two_factor_resetstatus").html('');
    $("#two_factor_reseticon").html('<i class="fa fa-spinner spin"></i>');
    $.ajax({
      url: '{{ route('api.users.two_factor_reset', ['id'=> $user->id]) }}',
      type: 'POST',
      data: {},
      headers: {
        "X-Requested-With": 'XMLHttpRequest',
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',

      success: function (data) {
        $("#two_factor_reset_toggle").html('').html('{{ trans('general.no') }}');
        $("#two_factor_reseticon").html('');
        $("#two_factor_resetstatus").html('<i class="fa fa-check text-success"></i>' + data.message);

      },

      error: function (data) {
        $("#two_factor_reseticon").html('');
        $("#two_factor_reseticon").html('<i class="fa fa-exclamation-triangle text-danger"></i>');
        $('#two_factor_resetstatus').text(data.message);
      }


    });
  });


    //binds to onchange event of your input field
    var uploadedFileSize = 0;
    $('#fileupload').bind('change', function() {
      uploadedFileSize = this.files[0].size;
      $('#progress-container').css('visibility', 'visible');
    });

    $('#fileupload').fileupload({
        //maxChunkSize: 100000,
        dataType: 'json',
        formData:{
        _token:'{{ csrf_token() }}',
        notes: $('#notes').val(),
        },

        progress: function (e, data) {
            //var overallProgress = $('#fileupload').fileupload('progress');
            //var activeUploads = $('#fileupload').fileupload('active');
            var progress = parseInt((data.loaded / uploadedFileSize) * 100, 10);
            $('.progress-bar').addClass('progress-bar-warning').css('width',progress + '%');
            $('#progress-bar-text').html(progress + '%');
            //console.dir(overallProgress);
        },

        done: function (e, data) {
            console.dir(data);

            // We use this instead of the fail option, since our API
            // returns a 200 OK status which always shows as "success"

            if (data && data.jqXHR.responseJSON.error && data.jqXHR.responseJSON && data.jqXHR.responseJSON.error) {
                $('#progress-bar-text').html(data.jqXHR.responseJSON.error);
                $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-danger').css('width','100%');
                $('.progress-checkmark').fadeIn('fast').html('<i class="fa fa-times fa-3x icon-white" style="color: #d9534f"></i>');
                console.log(data.jqXHR.responseJSON.error);
            } else {
                $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-success').css('width','100%');
                $('.progress-checkmark').fadeIn('fast');
                $('#progress-container').delay(950).css('visibility', 'visible');
                $('.progress-bar-text').html('Finished!');
                $('.progress-checkmark').fadeIn('fast').html('<i class="fa fa-check fa-3x icon-white" style="color: green"></i>');
                $.each(data.result.file, function (index, file) {
                    $('<tr><td>' + file.notes + '</td><<td>' + file.name + '</td><td>Just now</td><td>' + file.filesize + '</td><td><a class="btn btn-info btn-sm hidden-print" href="import/process/' + file.name + '"><i class="fa fa-spinner process"></i> Process</a></td></tr>').prependTo("#upload-table > tbody");
                });
            }
            $('#progress').removeClass('active');


        }
    });
});
</script>


@stop
