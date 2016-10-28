@extends('templates.main')

@section('content_title' , 'لیست محصولات دسته ی ' . $pcat->name )
@section('panel_size' , 'span12')

@section('content')
<div class="table-responsive">
	<a href="{{ route('product.create' , $pcat->id) }}" class="btn btn-success">محصول جدید</a>

	<table class="table table-hover table table-bordered" style="">
		<thead>
			<tr>
				<th>نام</th>
				<th>مشاهده - ویرایش - حذف</th>
			</tr>
		</thead>
		<tbody>
		@foreach($products as $product)
	  		<tr>
	  			<td>{{ $product->name }}</td>
	  			<td>
	  				<a href="{{ route('product.show' , $product->id)}}" class="btn btn-small btn-info">
	  					<i class="btn-icon-only icon-ok"></i>
	  				</a>
	  				<a href="{{ route('product.edit' , $product->id)}}" class="btn btn-small btn-warning">
	  					<i class="btn-icon-only  icon-edit"></i>
	  				</a>
	  				
	  				{!! Form::open([
	  					'method'=>'delete',
	  					'route' => [ 'product.destroy', $product->id ] ,
	  					'style' => 'display: inline',
	  					]) 
	  				!!}

	  				<button type="submit" class="btn btn-small btn-danger">
	  					<i class="btn-icon-only icon-remove"></i>
	  				</button>
	  				{!! Form::close() !!}
				</td>
	  		</tr>
	  	@endforeach
	  	</tbody>
	</table>
</div>
@endsection
