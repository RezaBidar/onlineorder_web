@extends('templates.main')

@section('content_title' , 'ثبت ویزیتور')
@section('panel_size' , 'span12')

@section('content')
	<div class="pull-left span6">
	{!! getOriginalAvatar($visitor->pic) !!}
	</div>
	{!! BootForm::open([
		'model' => isset($visitor) ? $visitor : null ,
		'store' => 'visitor.store', 
		'update' => 'visitor.update',
		'enctype' => 'multipart/form-data'
		]) !!}
	{!! BootForm::text('name') !!}
	{!! BootForm::text('username') !!}
	{!! BootForm::password('password') !!}
	{!! BootForm::text('tel') !!}
	{!! BootForm::submit('ذخیره') !!}
	{!! BootForm::close() !!}

@endsection
