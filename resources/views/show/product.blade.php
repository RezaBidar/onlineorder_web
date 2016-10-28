@extends('templates.main')

@section('content_title' , 'مشاهده محصول')
@section('panel_size' , 'span12')

@section('content')
{!! getProductPic($product->pic) !!}
<hr/>
<p><b>کد کالا : </b>{{ $product->code }}</p>
<p><b>نام کالا :</b> {{ $product->name }}</p>
<p><b>دسته بندی کالا :</b> {{ $product->category->name }}</p>
<p><b>واحد اندازه گیری :</b> {{ $product->unit }}</p>
<p><b>قیمت :</b> {{ $product->price }}</p>
<p><b>توضیحات :</b> {{ $product->description }}</p>

@endsection
