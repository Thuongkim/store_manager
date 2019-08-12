
@extends('layouts/default')

{{-- Page title --}}

@section('title')
{{ trans('general.customers') }}
@parent
@stop

@section('header_right')
    @can('create', \App\Models\Customer::class)
        <a href="{{ route('customers.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
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
                data-click-to-select="true"
                data-columns="{{ \App\Presenters\CustomerPresenter::dataTableLayout() }}"
                data-cookie-id-table="customersTable"
                data-pagination="true"
                data-id-table="customersTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-show-footer="true"
                data-sort-order="asc"
                id="customersTable"
                class="table table-striped snipe-table"
                data-url="{{route('api.customers.index') }}"
                data-export-options='{
                    "fileName": "export-customers-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop
s