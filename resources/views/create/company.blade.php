@extends('templates.main')

@section('content_title' , 'ثبت شرکت جدید')
@section('panel_size' , 'span12')

@section('content')
	
	{!! BootForm::open([
		'model' => isset($company) ? $company : null ,
		'store' => 'company.store', 
		'update' => 'company.update'
		]) !!}
	{!! BootForm::text('name' , trans('form.name')) !!}
	{!! BootForm::text('username' , trans('form.username')) !!}
	{!! BootForm::password('password' , trans('form.password')) !!}
	{!! BootForm::textarea('description' , trans('form.description')) !!}
	{!! BootForm::file('pic' , trans('form.pic')) !!}
	{!! BootForm::submit( trans('form.save') ) !!}
	{!! BootForm::close() !!}

@endsection
