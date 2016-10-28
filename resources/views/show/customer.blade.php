@extends('templates.main')

@section('content_title' , 'اطلاعات مشتری')
@section('panel_size' , 'span12')

@section('content')

{!! getOriginalAvatar($user->pic) !!}
<hr/>
<p><b>نام : </b>{{ $user->name }}</p>
<p><b>نام کاربری :</b> {{ $user->username }}</p>
<p><b>شماره تلفن :</b> {{ $user->tel }}</p>
<p><b>آدرس :</b> {{ $user->address }}</p>
<p><b>توضیحات :</b> {{ $user->description }}</p>
<p><b>امتیاز :</b> {{ $company->score }}</p>
<hr />
<p><b>نام ویزیتور :</b> {{ $visitor->name }}</p>
<p><b>آی دی ویزیتور :</b> {{ $visitor->getCompany()->pivot->id }}</p>
<p><b>تعداد سفارشات :</b> {{ sizeof($user->orders) }}</p>


@endsection
