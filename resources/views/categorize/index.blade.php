@extends('layouts/default')

{{-- Page title --}}
@section('title')
Categorize
@parent
@stop


@section('header_right')

<a href="{{ route('categorize.create') }}" class="btn btn-primary pull-right">{{ trans('general.create') }}</a>

@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

          <table
          data-columns="{{ \App\Presenters\CategorizePresenter::dataTableLayout() }}"
          data-cookie-id-table="categorizeTable"
          data-pagination="true"
          data-id-table="categorizeTable"
          data-search="true"
          data-show-footer="true"
          data-side-pagination="server"
          data-show-columns="true"
          data-show-export="true"
          data-show-refresh="true"
          data-sort-order="asc"
          id="categorizeTable"
          class="table table-striped snipe-table"
          data-url="{{ route('api.categorize.index') }}"
          data-export-options='{
              "fileName": "export-categorize-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions"]
              }'>
      </table>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table',
      ['exportFile' => 'categorize-export',
      'search' => true,
      'columns' => \App\Presenters\CategorizePresenter::dataTableLayout()
  ])
  @stop

