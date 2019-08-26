
@extends('layouts/edit-form', [
'createText' => trans('admin/customers/general.create') ,
'updateText' => trans('admin/customers/general.update'),
'formAction' => ($item) ? route('customers.update', ['customer' => $item->id]) : route('customers.store'),
])
<!-- Item are Customer Object - Lock at the create method of CustomersController  -->
{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/customers/general.customer_name')])
@include ('partials.forms.edit.phone', ['translated_name' => trans('admin/customers/general.phone')])
@include ('partials.forms.edit.address', ['translated_name' => trans('admin/customers/general.address')])
@include ('partials.forms.edit.taxcode', ['translated_name' => trans('admin/customers/general.taxcode')])
@include ('partials.forms.edit.email', ['translated_name' => trans('admin/customers/general.email')])

@stop
