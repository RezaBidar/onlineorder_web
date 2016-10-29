@extends('templates.main')

@section('content_title' , 'لیست محصولات')
@section('panel_size' , 'span12')

@section('content')


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
								<th>قیمت</th>
								<th>توضیحات</th>
							</tr>
						</thead>
						<tbody>
						@foreach($productss as $product)
					  		<tr>
					  			<td>{!! getProductThumb($product->pic) !!}</td>
					  			<td>{{ $product->code }}</td>
					  			<td>{{ $product->name }}</td>
					  			<td>{{ $product->price }}</td>
					  			<td>{{ removeBr($product->description) }}</td>
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
