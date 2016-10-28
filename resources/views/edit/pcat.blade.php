

@extends('templates.main')

@section('content_title' , 'ثبت دسته بندی جدید')
@section('panel_size' , 'span12')

@section('content')
	
	{!! BootForm::open([
		'model' => isset($pcat) ? $pcat : null ,
		'store' => 'pcat.store', 
		'update' => 'pcat.update'
		]) !!}
	{!! BootForm::text('name') !!}
	{!! BootForm::submit('ذخیره') !!}
	{!! BootForm::close() !!}

@endsection
