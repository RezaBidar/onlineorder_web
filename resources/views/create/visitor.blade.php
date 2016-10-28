@extends('templates.main')

@section('content_title' , 'ثبت ویزیتور')
@section('panel_size' , 'span12')

@section('content')
	
	{!! BootForm::open([
		'model' => isset($visitor) ? $visitor : null ,
		'store' => 'visitor.store', 
		'update' => 'visitor.update',
		'enctype' => 'multipart/form-data'
		]) !!}
	{!! BootForm::text('name' , trans('form.name')) !!}
	{!! BootForm::text('username' , trans('form.username')) !!}
	{!! BootForm::password('password' , trans('form.password')) !!}
	{!! BootForm::text('tel' , trans('form.tel')) !!}
	{!! BootForm::textarea('description' , trans('form.description')) !!}
	{!! BootForm::file('pic' , trans('form.pic')) !!}
	{!! BootForm::submit(trans('form.save')) !!}
	{!! BootForm::close() !!}

@endsection
