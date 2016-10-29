@extends('templates.main')

@section('content_title' , 'لیست سفارشات' . '<a href="'. route('order.create') .'" class="btn btn-info pull-left">ثبت سفارش جدید</a>')
@section('panel_size' , 'span12')

@section('content')


{!! BootForm::open(['method' => 'GET'])!!}
<div class="pull-right">
<div class="span3">
{!! BootForm::select('customer' , 'مشتری' , $customers , $sCustomer)!!}
</div>
@if(Auth::user()->isOperator())
<div class="span3">
{!! BootForm::select('visitor' , 'ویزیتور' , $visitors, $sVisitor)!!}
</div>
@endif
<div class="span3">
{!! BootForm::select('status' , 'وضعیت' , $statuses, $sStatus)!!}
</div>
</div>
<input type="submit" class="btn btn-warning pull-left" value="اعمال فیلتر"/>
{!! BootForm::close() !!}

<div class="table-responsive">
	<table class="table table-hover table table-bordered" style="">
		<thead>
			<tr>
				<th>کد</th>
				<th>نام مشتری</th>
				<th>نام ویزیتور</th>
				<th>وضعیت سفارش</th>
				<th>تعداد</th>
				<th>تاریخ</th>
				<th>انتخاب</th>
			</tr>
		</thead>
		<tbody>
		@foreach($orders as $order)
	  		<tr>
	  			<td>#{{ $order->id }}</td>
	  			<td>{{ $order->customer->name }}</td>
	  			<td>{{ $order->visitor->name }}</td>
	  			<td>{!! $order->getStatusLabel($order->status) !!}</td>
	  			<td>{{ sizeof($order->products) }}</td>
	  			<td>{{ \Morilog\Jalali\jDateTime::convertNumbers(\Morilog\Jalali\jDateTime::strftime('H:i:s Y-m-d', strtotime($order->created_at))) }}</td>
	  			<td>
	  				<a href="{{ route('productorder' , $order->id)}}" class="btn btn-small btn-info">
	  					<i class="btn-icon-only icon-ok"></i>
	  				</a>
	  				{{-- <a href="{{ route('order.edit' , $order->id)}}" class="btn btn-small btn-warning">
	  					<i class="btn-icon-only  icon-edit"></i>
	  				</a> --}}
	  				
	  				{{-- {!! Form::open([
	  					'method'=>'delete',
	  					'route' => [ 'order.destroy', $order->id ] ,
	  					'style' => 'display: inline',
	  					]) 
	  				!!}

	  				<button type="submit" class="btn btn-small btn-danger">
	  					<i class="btn-icon-only icon-remove"></i>
	  				</button>
	  				{!! Form::close() !!} --}}
				</td>
	  		</tr>
	  	@endforeach
	  	</tbody>
	</table>
	{!! $orders->links() !!}
</div>
@endsection

@section('javascript')
$(document).ready(function(){
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	var s = '';
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        if(hash[0] != 'page')
        {
        	s += '&' + hash[0] + '=' + hash[1] ;
        }
    }
    
	$(".pagination a").each(function() {
	   var $this = $(this);       
	   var _href = $this.attr("href"); 
	   $this.attr("href", _href + s);
	});	
});




@endsection
