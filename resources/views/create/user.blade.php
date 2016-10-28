@extends('templates.main')

@section('content_title' , 'ثبت کاربر جدید')
@section('panel_size' , 'span12')

@section('content')
	
	{!! BootForm::open([
		'model' => isset($company) ? $company : null ,
		'store' => 'user.store', 
		'update' => 'user.update'
		]) !!}
	{!! BootForm::text('name' , trans('form.name')) !!}
	{!! BootForm::text('username' , trans('form.username')) !!}
	{!! BootForm::password('password' , trans('form.password')) !!}
	{!! BootForm::submit(trans('form.save')) !!}
	{!! BootForm::close() !!}

@endsection
