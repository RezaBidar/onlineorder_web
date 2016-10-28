@extends('templates.main')

@section('content_title' , 'ویرایش محصول')
@section('panel_size' , 'span12')

@section('content')
	<div class="pull-left span6">
	{!! getProductPic($product->pic) !!}
	</div>
	{!! BootForm::open([
		'model' => isset($product) ? $product : null ,
		'store' => 'product.store', 
		'update' => 'product.update',
		'enctype' => 'multipart/form-data'
		]) !!}
	{!! BootForm::text('code' , trans('form.pcode')) !!}
	{!! BootForm::text('name' , trans('form.name')) !!}
	{!! BootForm::textarea('description' , trans('form.description')) !!}
	{!! BootForm::text('unit' , trans('form.unit')) !!}
	{!! BootForm::text('price' , trans('form.price')) !!}
	{!! BootForm::file('pic' , trans('form.pic')) !!}
	{!! BootForm::submit('ذخیره') !!}
	{!! BootForm::close() !!}

@endsection
