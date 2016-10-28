

@extends('templates.main')

@section('content_title' , 'ثبت دسته بندی جدید')
@section('panel_size' , 'span12')

@section('content')
	
	{!! BootForm::open([
		'model' => isset($company) ? $company : null ,
		'store' => 'pcat.store', 
		'update' => 'pcat.update'
		]) !!}
	{!! BootForm::text('name' , trans('form.name')) !!}
	{!! BootForm::submit(trans('form.save')) !!}
	{!! BootForm::close() !!}

@endsection
