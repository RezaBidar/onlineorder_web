@extends('templates.main')

@section('content_title' , 'ثبت محصول جدید در دسته ی ' . $pcat->name)
@section('panel_size' , 'span12')

@section('content')
	
	{!! BootForm::open([
		'model' => isset($product) ? $product : null ,
		'store' => 'product.store', 
		'update' => 'product.update' ,
		'enctype' => 'multipart/form-data'
		]) !!}
	{!! BootForm::text('code' , trans('form.pcode')) !!}
	{!! BootForm::text('name' , trans('form.name')) !!}
	{!! BootForm::textarea('description' , trans('form.description')) !!}
	{!! BootForm::text('unit' , trans('form.unit')) !!}
	{!! BootForm::text('price' , trans('form.price')) !!}
	{!! BootForm::file('pic' , trans('form.pic')) !!}
	{!! BootForm::hidden('category_id' , $pcat->id) !!}
	{!! BootForm::submit(trans('form.save')) !!}
	{!! BootForm::close() !!}

@endsection
