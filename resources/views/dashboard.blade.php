@extends('templates.main')

@section('title' , 'خانه')

@section('content_title' , 'داشبورد')

@section('content')


						
              		<div class="span5 pull-right">
              		<p>سلام </p>
              		<p>خوش امدید</p>
              		<p>نرم افزار پخشیار به شما کمک میکند که تا مدیریت بهتری بر رو پخش کالای خود به وسیله ویزیتورها داشته باشید 
              		برای اینکه با بخش های مختلف سیستم بیشتر اشنا بشید لطفن <a href="#">اینجا</a> کلیک کنید</p>
              		</div>

              		<div class="span6 pull-left">
	                  <div id="big_stats" class="cf">
	                    <div class="stat"> 
	                     <i class="icon-th-list"></i> <p>منتظر</p>
	                     
						@if(Auth::user()->isVisitor())
	                    <a href="{{ route('order.index').'?status=' . App\Order::STATUS_REQUEST_V }}
	                    @else
	                    <a href="{{ route('order.index').'?status=' . App\Order::STATUS_REQUEST_O }}
	                    @endif
	                     ">
	                     <span class="value">{{ $requests }}</span></a> </div>
	                    <!-- .stat -->
	                    
	                    <div class="stat"> <i class="icon-ok"></i> <p>تایید شده</p> 
	                    @if(Auth::user()->isVisitor())
	                    <a href="{{ route('order.index') . '?status=' . App\Order::STATUS_ACCEPT_V }}
	                    @else
	                    <a href="{{ route('order.index') . '?status=' . App\Order::STATUS_ACCEPT_O }}
	                    @endif
	                    ">
	                    <span class="value">{{ $accepted }}</span></a> </div>
	                    <!-- .stat -->
	                    
	                    <div class="stat"> <i class="icon-barcode"></i> <p>کالا</p>
	                    <a href="{{ route('product.index') }}">
	                    <span class="value">{{ $products }}</span></a> </div>
	                    <!-- .stat -->
	                    

	                    <div class="stat"> <i class="icon-heart"></i> <p>مشتری</p>
	                    <a href="{{ route('customer.index') }}">
	                    <span class="value">{{ $customers }}</span> </a></div>
	                    <!-- .stat -->

	                    
	                    
	                    


	                  </div>
                  </div>
						
						
						
						
						
@endsection