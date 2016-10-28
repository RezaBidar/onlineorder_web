@extends('templates.main')

@section('content_title' , 'کالاهای سفارش داده شده <br/> کد سفارش : # ' . $orderId . ' <br/> ' . 'سفارش دهنده : ' . $customerName .'<br /> ویزیتور :' . $visitorName )
@section('panel_size' , 'span12')

@section('content')


<div class="table-responsive">
	<div id="orderstatus" class="control-group pull-left">
	
	@if( (Auth::user()->type == App\User::TYPE_VISITOR && $order->status == App\Order::STATUS_ACCEPT_V ) ||  $order->status == App\Order::STATUS_ACCEPT_O )
		<span class="alert alert-success" > سفارش تایید شد </span> 
	@elseif(in_array($order->status , [App\Order::STATUS_REJECT_V , App\Order::STATUS_REJECT_O]))
		<span class="alert alert-danger" > سفارش رد شد </span> 

	@elseif(in_array($order->status , [App\Order::STATUS_REQUEST_O , App\Order::STATUS_REQUEST_V] ))
	<a href="#" value="1" class="btn btn-success orderstatusbtn">تایید سفارش</a>
	<a href="#" value="0" class="btn btn-danger orderstatusbtn">لغو سفارش</a>
	
	@endif
	</div><!-- end of orderstatus-->
	@if(Auth::user()->isVisitor())
	<a href="{{ route('order.edit' , ['id' => $order->id])}}" class="btn btn-warning">ویرایش</a>
	<hr/>
	@endif
	<table class="table table-hover table table-bordered" style="">
		<thead>
			<tr>
				<th style="width: 50px">عکس</th>
				<th>کد کالا</th>
				<th>نام</th>
				<th>تعداد</th>
				<th>قیمت</th>
				<th>قیمت کل</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$num = 0 ;
			$price = 0 ;
		?>
		@foreach($products as $productorder)
			<?php 
			$product = $productorder->product ; 
			$finalprice = $productorder->num * $productorder->price ;
			?>
	  		<tr>
	  			<td>{!! getProductThumb($product->pic) !!}</td>
	  			<td>{{ $product->code }}</td>
	  			<td>{{ $product->name }}</td>
	  			<td>{{ $productorder->num }}</td>
	  			<td>{{ $productorder->price }}</td>
	  			<td>{{ $finalprice }}</td>
	  			
	  			
	  		</tr>
	  		<?php 
	  			$num += $productorder->num ;
	  			$price += $finalprice ;
	  		?>
	  	@endforeach
	  		<tr style="background-color: #aaa">
		  		<td>مجموع</td>
		  		<td></td>
		  		<td></td>
	  			<td>{{ $num }}</td>
	  			<td></td>
	  			<td>{{ $price }}</td>
	  		</tr>
	  	</tbody>
	</table>
</div>
@endsection

@section('javascript')

$(document).ready(function(){


	
	$(".orderstatusbtn").click(function(e){
		e.preventDefault();
		sval = $(this).attr("value");
		url = '{{ route('orderstatus' , [$orderId , 'sval'] ) }}' ;
		$.ajax({
				url : url.replace('sval' , sval) ,
				success : function(result){
					if(result > 0 )
					{
						//bootbox.alert('عملیات با موفقیت انجام شد');
						if( result == 1)
							$("#orderstatus").html('<span class="alert alert-danger" > سفارش رد شد </span>');
						else 
							$("#orderstatus").html('<span class="alert alert-success" > سفارش تایید شد </span> ');
					}
					else
					{
						bootbox.alert('ختی در عملیات .. دوباره تلاش کنید');
					}


				}
		});

	});


		
	
});

@endsection