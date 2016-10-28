@extends('templates.main')

@section('content_title' , 'مشاهده کاربر')
@section('panel_size' , 'span12')

@section('content')

{!! getAvatar($customer->pic) !!}

<p>نام : {{ $customer->name }}</p>
<p>نام کاربری : {{ $customer->name }}</p>
<p>شماره تلفن : {{ $customer->name }}</p>
<p>امتیاز : {{ $customer->name }}</p>
<p>نام ویزیتور : {{ $customer->name }}</p>
<p>آی دی ویزیتور : {{ $customer->name }}</p>
<p>تعداد سفارشات : {{ $customer->name }}</p>


@endsection
