@extends('templates.main')

@section('content_title' , ' ویرایش سفارش ' . $customer->name)
@section('panel_size' , 'span12')

@section('content')

<div class="pull-left">
<a href="#" class="btn btn-success" id="saveOrder" >ذخیره</a>
 
<a href="{{route('productorder' , ['id' => $order->id])}}" class="btn btn-danger" >انصراف</a>
</div>

<span class="pull-left" >  </span>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<?php $first = true ; $activeId = 0 ?>
		@foreach( $pcats as $pcat )
			@if($first)
				<li  class="active">
				<?php 
				$first = false ;
				$activeId = $pcat->id ;
				?>
			@else
				<li>
			@endif	
		  
		    <a href="#tab{{ $pcat->id }}" data-toggle="tab">{{ $pcat->name }}</a>
		  	</li>
	  	@endforeach
	</ul>
	
	<br>
	
		<div class="tab-content">

			@foreach($products as $pcatId => $productss)
				
				@if($pcatId == $activeId)
					<div class="tab-pane active" id="tab{{ $pcatId }}">
				@else
					<div class="tab-pane" id="tab{{ $pcatId }}">
				@endif 
					
					
					<div class="table-responsive">
					<table class="table table-hover table table-bordered" style="">
						<thead>
							<tr>
								<th style="width: 50px">عکس</th>
								<th>کد</th>
								<th>نام</th>
								<th>واحد</th>
								<th>قیمت</th>
								<th>توضیحات</th>
								<th>تعداد</th>
							</tr>
						</thead>
						<tbody>
						@foreach($productss as $product)
					  		<tr>
					  			<td>{!! getProductThumb($product->pic) !!}</td>
					  			<td>{{ $product->code }}</td>
					  			<td>{{ $product->name }}</td>
					  			<td>{{ $product->unit }}</td>
					  			<td>{{ $product->price }}</td>
					  			<td>{{ $product->description }}</td>
					  			<td>{!! BootForm::number('num' . $product->id ,' ', 
					  			(isset($op[$product->id])) ? $op[$product->id] : '' , ['class'=>'numinput' , 'id' => $product->id]) !!}</td>
					  		</tr>
					  	@endforeach
					  	</tbody>
					</table>
				</div>
				
				
				</div>
			@endforeach
			
			
				
			
		</div>
	  
	  
</div>

@endsection


@section('javascript')

$(document).ready(function(){

	var redirectUrl = '{{ route('productorder' , ['id' => $order->id])}}' ;

	$("#saveOrder").click(function(e){
		e.preventDefault();
		
		var customerId = $('select[name=customer]').val();
		var products = new Array();
		$(".numinput").each(function(i){
			var pid = $(this).attr("id");
			var val = $(this).attr("value"); 
			var obj = new Object();

			if(val.trim()){
				obj.k = pid ;
				obj.v = val ;
				products.push(obj);
			}
		});

		$.ajax({
				url : '{{route('order.update' , ['id' => $order->id])}}' ,
				data : {orderId : {{$order->id}} , products : JSON.stringify(products)} ,
				success : function(r){
					var result = $.map(r, function(el) { return el });
					if(result[0] == "success"){
						window.location.href = redirectUrl;
					}
					else{
						bootbox.alert("خطا رخ داده است");
					}
				}
		});


	});
	

		

	
});

@endsection 