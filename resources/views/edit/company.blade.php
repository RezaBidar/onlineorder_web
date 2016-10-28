@extends('templates.main')

@section('content_title' , 'ثبت شرکت جدید')
@section('panel_size' , 'span12')

@section('content')
	
	{!! BootForm::open([
		'model' => isset($company) ? $company : null ,
		'store' => 'company.store', 
		'update' => 'company.update'
		]) !!}
	{!! BootForm::text('name') !!}
	{!! BootForm::text('username') !!}
	{!! BootForm::password('password') !!}
	{!! BootForm::submit('ذخیره') !!}
	{!! BootForm::close() !!}

@endsection
