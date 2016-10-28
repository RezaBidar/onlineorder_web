@extends('templates.main')

@section('content_title' , 'مشاهده ویزیتور')
@section('panel_size' , 'span12')

@section('content')

{!! getOriginalAvatar($visitor->pic) !!}
<hr/>
<p><b>نام : </b>{{ $visitor->name }}</p>
<p><b>نام کاربری :</b> {{ $visitor->username }}</p>
<p><b>شماره تلفن :</b> {{ $visitor->tel }}</p>
<p><b>آدرس :</b> {{ $visitor->address }}</p>
<p><b>توضیحات :</b> {{ $visitor->description }}</p>
<hr />
<h3>لیست مشتریان</h3>
<br/>
@foreach($visitor->customers as $customer)
	<p>{{ $customer->name }}</p>
@endforeach

@endsection
