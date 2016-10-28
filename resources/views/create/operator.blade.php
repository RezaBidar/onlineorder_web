@extends('templates.main')

@section('content_title' , 'ثبت اپراتور جدید')
@section('panel_size' , 'span12')

@section('content')
	
	{!! BootForm::open([
		'model' => isset($company) ? $company : null ,
		'store' => 'operator.store', 
		'update' => 'operator.update'
		]) !!}
	{!! BootForm::text('name' , trans('form.name')) !!}
	{!! BootForm::text('username' , trans('form.username')) !!}
	{!! BootForm::password('password' , trans('form.password')) !!}
	{!! BootForm::text('tel' , trans('form.tel')) !!}
	{!! BootForm::submit(trans('form.save')) !!}
	{!! BootForm::close() !!}

@endsection
