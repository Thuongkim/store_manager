<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@extends('layouts/edit-form', [
'createText' => trans('admin/warnings/general.create') ,
'updateText' => trans('admin/warnings/general.update'),
'formAction' => ($item) ? route('warnings.update', ['warning' => $item->id]) : route('warnings.store'),
])
<!-- Item là một đối tượng của Warning - Xem hàm create của WarningsController  -->
{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.customer-select', ['translated_name' => trans('admin/warnings/general.warning_name'), 'fieldname' => 'id_customer'])
@include ('partials.forms.edit.created-customer', ['translated_name' => trans('admin/warnings/general.created_customer')])
@include ('partials.forms.edit.duration', ['translated_name' => trans('admin/warnings/general.duration')])
@include ('partials.forms.edit.warning-before', ['translated_name' => trans('admin/warnings/general.warning_before')])
@include ('partials.forms.edit.hour-warning', ['translated_name' => trans('admin/warnings/general.hour_warning')])
@include ('partials.forms.edit.view-calendar', ['translated_name' => trans('admin/warnings/general.view_calendar')])

@stop
<script>
	$(document).ready(function(){
		$('#customer_select').change(function(){
			var idCustomer = $(this).val();
			$.get("/warnings/ajax/" + idCustomer, function(data){
				$('#lb').html(data);
			});
		});
	});
</script>
