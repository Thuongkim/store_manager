@extends('layouts/default')

{{-- Page title --}}
@section('title')
Contract
@parent
@stop


@section('header_right')

<a href="{{ route('contract.create') }}" class="btn btn-primary pull-right">{{ trans('general.create') }}</a>

@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

          <table
          data-columns="{{ \App\Presenters\ContractPresenter::dataTableLayout() }}"
          data-cookie-id-table="contractTable"
          data-pagination="true"
          data-id-table="contractTable"
          data-search="true"
          data-show-footer="true"
          data-side-pagination="server"
          data-show-columns="true"
          data-show-export="true"
          data-show-refresh="true"
          data-sort-order="asc"
          id="contractTable"
          class="table table-striped snipe-table"
          data-url="{{ route('api.contract.index') }}">
        </table>
      </div>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>
</div>

@stop



@section('zoom-img')
<script>
  $(document).on("click", '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
  });

</script>
@stop
@section('moar_scripts')
@include ('partials.bootstrap-table',
  ['exportFile' => 'contract-export',
  'search' => true,
  'columns' => \App\Presenters\ContractPresenter::dataTableLayout()
  ])
  @stop

