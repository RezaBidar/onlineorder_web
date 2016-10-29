@extends('templates.main')

@section('content_title' , 'لیست محصولات')
@section('panel_size' , 'span12')

@section('content')
<a href="{{ route('pcat.create') }}" class="btn btn-info pull-left">دسته بندی جدید</a>
					
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
					
					<a href="{{ route('product.create' , $pcatId) }}" class="btn btn-success">محصول جدید</a>
					<hr/>
					<div class="table-responsive">
					<table class="table table-hover table table-bordered" style="">
						<thead>
							<tr>
								<th style="width: 50px">عکس</th>
								<th>کد</th>
								<th>نام</th>
								<th>قیمت</th>
								<th>توضیحات</th>
								<th>مشاهده - ویرایش </th>
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
					  			<td>
					  				<a href="{{ route('product.show' , $product->id)}}" class="btn btn-small btn-info">
					  					<i class="btn-icon-only icon-ok"></i>
					  				</a>
					  				<a href="{{ route('product.edit' , $product->id)}}" class="btn btn-small btn-warning">
					  					<i class="btn-icon-only  icon-edit"></i>
					  				</a>
					  				
					  				{{-- {!! Form::open([
					  					'method'=>'delete',
					  					'route' => [ 'product.destroy', $product->id ] ,
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
				</div>
				
				
				</div>
			@endforeach
			
			
				
			
		</div>
	  
	  
</div>

@endsection
