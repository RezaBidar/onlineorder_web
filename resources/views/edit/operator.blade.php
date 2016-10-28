@extends('templates.main')

@section('content_title' , 'ثبت اپراتور جدید')
@section('panel_size' , 'span12')

@section('content')
	
	{!! BootForm::open([
		'model' => isset($company) ? $company : null ,
		'store' => 'operator.store', 
		'update' => 'operator.update'
		]) !!}
	{!! BootForm::text('name') !!}
	{!! BootForm::text('username') !!}
	{!! BootForm::password('password') !!}
	{!! BootForm::text('tel') !!}
	{!! BootForm::submit('ذخیره') !!}
	{!! BootForm::close() !!}

@endsection
