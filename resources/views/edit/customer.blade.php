@extends('templates.main')

@section('content_title' , 'ویرایش مشتری "' . $customer->username . '"')
@section('panel_size' , 'span12')

@section('content')
	<div class="pull-left span6">
	{!! getOriginalAvatar($customer->pic) !!}
	</div>
	{!! BootForm::open([
		'model' => isset($customer) ? $customer : null ,
		'store' => 'customer.store', 
		'update' => 'customer.update',
		'enctype' => 'multipart/form-data'
		]) !!}
	{!! BootForm::text('name' , trans('form.name')) !!}
	{{-- {!! BootForm::text('username' , trans('form.username')) !!} --}}
	{!! BootForm::password('password' , trans('form.password')) !!}
	{!! BootForm::text('tel' , trans('form.tel')) !!}
	{!! BootForm::text('address' , trans('form.address')) !!}
	{!! BootForm::textarea('description' , trans('form.description')) !!}
	{!! BootForm::file('pic' , trans('form.pic')) !!}
	{!! BootForm::select('visitor_id' , trans('form.visitor') , $visitors) !!}
	{!! BootForm::submit( trans('form.save') ) !!}
	{!! BootForm::close() !!}

@endsection
