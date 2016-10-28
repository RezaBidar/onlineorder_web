@extends('templates.main')

@section('content_title' , 'ثبت کاربر جدید')
@section('panel_size' , 'span12')

@section('content')
	
	{!! BootForm::open([
		'model' => isset($company) ? $company : null ,
		'store' => 'user.store', 
		'update' => 'user.update'
		]) !!}
	{!! BootForm::text('name') !!}
	{!! BootForm::text('username') !!}
	{!! BootForm::password('password') !!}
	{!! BootForm::submit('ذخیره') !!}
	{!! BootForm::close() !!}

@endsection
