@extends('templates.main')

@section('content_title' , 'کالاهای سفارش داده شده <br/> کد سفارش : # ' . $orderId . ' <br/> ' . 'سفارش دهنده : ' . $customerName .'<br /> ویزیتور :' . $visitorName )
@section('panel_size' , 'span12')

@section('content')


<div class="table-responsive">
	<div id="orderstatus" class="control-group">
	
	@if( (Auth::user()->type == App\User::TYPE_VISITOR && $order->status == App\Order::STATUS_ACCEPT_V ) ||  $order->status == App\Order::STATUS_ACCEPT_O )
		<span class="alert alert-success" > سفارش تایید شد </span> 
	@elseif(in_array($order->status , [App\Order::STATUS_REJECT_V , App\Order::STATUS_REJECT_O]))
		<span class="alert alert-danger" > سفارش رد شد </span> 

	@elseif(in_array($order->status , [App\Order::STATUS_REQUEST_O , App\Order::STATUS_REQUEST_V] ))
	<a href="#" value="1" class="btn btn-success orderstatusbtn">تایید سفارش</a>
	<a href="#" value="0" class="btn btn-danger orderstatusbtn">لغو سفارش</a>
	
	<hr/>
	<div class="control-group">
		<div class="controls">
			 <!-- Button to trigger modal -->
            <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">اضافه کردن محصول</a>
            <a href="#" role="button" class="btn btn-info addToBox" data-toggle="modal">اضافه کردن محصول</a>
            <!-- Modal -->
            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">اظافه کردن محصول</h3>
              </div>
              <div class="modal-body">
                <label for="pcode">کد محصول</label>
                <input type="text" class="form-controller" />
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">بیخیال</button>
                <button class="btn btn-primary" data-dismiss="modal" onclick="sayHello()">اضافه کردن</button>
              </div>
            </div>
		</div> <!-- /controls -->	
	</div> <!-- /control-group -->
	
	@endif
	</div><!-- end of orderstatus-->
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


		
		
	$(".addToBox").click(function(e){
		e.preventDefault();
		bootbox.prompt({
		    title: "کدر محصول را وارد کنید",
		    inputType: 'text',
		    callback: function (result) {
		        $.ajax({
		        	url : '{{ route('orderstatus' , [$orderId , 'sval'] ) }}' ,
		        	success : function(result)
		        	{
		        		if(result == 1)
						    location.reload();
		        		else 
		        			bootbox.alert("عملیات با خطا مواجه شد ...");
		        	}
		        });
			}
		});
	});

	
});

@endsection