@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.appendixes') }}
@parent
@stop

@section('header_right')
    @can('create', \App\Models\Appendix::class)
        <a href="{{ route('appendixes.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
    @endcan
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

            <table
                data-columns="{{ \App\Presenters\AppendixPresenter::dataTableLayout() }}"
                data-cookie-id-table="appendixesTable"
                data-pagination="true"
                data-id-table="appendixesTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-show-footer="true"
                data-sort-order="asc"
                id="appendixesTable"
                class="table table-striped snipe-table"
                data-url="{{route('api.appendixes.index') }}"
                data-export-options='{
                    "fileName": "export-appendixes-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@stop
@section('zoom-img')
<script>
  $(document).ready(function() {
      $('[data-fancybox]').each(function(){
          $(this).attr('data-caption', $(this).attr('title'));
      });
      $('[data-fancybox]').fancybox();
  });
</script>
@stop
@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop
