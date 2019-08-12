@extends('layouts/default')

{{-- Page title --}}
@section('title')
View Customer: {{ $customer->name }}
@parent
@stop

{{-- Page content --}}
@section('content')
@can('view', \App\Models\Customer::class)
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs hidden-print">

        <li class="active">
          <a href="#details" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fa fa-info-circle"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('admin/customers/general.info') }}</span>
          </a>
        </li>

        @can('update', $customer)
          <li class="dropdown pull-right">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-gear"></i> {{ trans('button.actions') }}
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('customers.edit', $customer->id) }}">{{ trans('admin/customers/general.edit') }}</a></li>
              <li><a href="{{ route('customers.destroy', $customer->id) }}">{{ trans('button.delete') }}</a></li>
            </ul>
          </li>
        @endcan
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="details">
          <div class="row">
            @if ($user->deleted_at!='')
              <div class="col-md-12">
                <div class="callout callout-warning">
                  <i class="icon fa fa-warning"></i>
                  {{ trans('admin/customers/message.user_deleted_warning') }}
                  @can('update', $customer)
                      <a href="{{ route('restore/customer', $user->id) }}">{{ trans('admin/users/general.restore_user') }}</a>
                  @endcan
                </div>
              </div>
            @endif
            <div class="col-md-8">
              <div class="table table-responsive">
                <table class="table table-striped" style="font-size: 14px;">
                  @if (!is_null($customer->name))
                    <tr>
                        <td class="text-nowrap">{{ trans('general.name') }}</td>
                        <td>{{ $customer->name }}</td>
                    </tr>
                  @endif

                  @if (!is_null($customer->phone))
                    <tr>
                        <td class="text-nowrap">{{ trans('general.phone') }}</td>
                        <td>{{ $customer->phone }}</td>
                    </tr>
                  @endif

                  @if (!is_null($customer->address))
                    <tr>
                        <td class="text-nowrap">{{ trans('general.address') }}</td>
                        <td>{{ $customer->address }}</td>
                    </tr>
                  @endif

                  @if (!is_null($customer->city))
                    <tr>
                        <td class="text-nowrap">{{ trans('general.city') }}</td>
                        <td>{{ $customer->city }}</td>
                    </tr>
                  @endif

                  @if (!is_null($customer->state))
                    <tr>
                        <td class="text-nowrap">{{ trans('general.state') }}</td>
                        <td>{{ $customer->state }}</td>
                    </tr>
                  @endif

                  @if (!is_null($customer->country))
                    <tr>
                        <td class="text-nowrap">{{ trans('general.country') }}</td>
                        <td>{{ $customer->country }}</td>
                    </tr>
                  @endif

                  @if (!is_null($customer->zip))
                    <tr>
                        <td class="text-nowrap">{{ trans('general.zip') }}</td>
                        <td>{{ $customer->zip }}</td>
                    </tr>
                  @endif

                  @if (!is_null($customer->taxcode))
                    <tr>
                        <td class="text-nowrap">{{ trans('general.taxcode') }}</td>
                        <td>{{ $customer->taxcode }}</td>
                    </tr>
                  @endif

                  @if (!is_null($customer->email))
                    <tr>
                        <td class="text-nowrap">{{ trans('general.email') }}</td>
                        <td>{{ $customer->email }}</td>
                    </tr>
                  @endif

                  <tr>
                      <td style="padding-top: 30px"><a href="{{ route('customers.index') }}" class="btn btn-primary btn-sm">Come back</a></td>
                  </tr>

                </table>
              </div>
            </div>

            <!-- Start button column -->
            <div class="col-md-2">
              @can('update', $customer)
                <div class="col-md-12">
                  <a href="{{ route('customers.edit', $customer->id) }}" style="width: 100%;" class="btn btn-sm btn-success hidden-print">{{ trans('admin/customers/general.edit') }}</a>
                </div>
              @endcan     

              @can('delete', $customer)
                @if ($customer->deleted_at=='')
                  <div class="col-md-12" style="padding-top: 5px;">
                    <!-- <form action="{{route('customers.destroy',$customer->id)}}" method="POST"> -->
                      {{csrf_field()}}
                      {{ method_field("DELETE")}}
                      <button style="width: 100%;" class="btn btn-sm btn-warning hidden-print">{{ trans('button.delete')}}</button>
                    <!-- </form> -->
                  </div>
                  <div class="col-md-12" style="padding-top: 5px;">
                    <form action="{{ route('users/bulkedit') }}" method="POST">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                      <input type="hidden" name="ids[{{ $user->id }}]" value="{{ $user->id }}" />
                      <button style="width: 100%;" class="btn btn-sm btn-danger hidden-print">{{ trans('button.checkin_and_delete') }}</button>
                    </form>
                  </div>
                @else
                  <div class="col-md-12" style="padding-top: 5px;">
                    <a href="{{ route('restore/user', $user->id) }}" style="width: 100%;" class="btn btn-sm btn-warning hidden-print">{{ trans('button.restore') }}</a>
                  </div>
                @endif
              @endcan

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endcan

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
