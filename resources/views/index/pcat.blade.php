@extends('templates.main')

@section('content_title' , 'لیست دسته بندی محصولات')
@section('panel_size' , 'span12')

@section('content')
<div class="table-responsive">
	<table class="table table-hover table table-bordered" style="">
		<thead>
			<tr>
				<th>نام</th>
				<th>مشاهده - ویرایش - حذف</th>
			</tr>
		</thead>
		<tbody>
		@foreach($pcats as $pcat)
	  		<tr>
	  			<td>{{ $pcat->name }}</td>
	  			<td>
	  				<a href="{{ route('pcat.show' , $pcat->id)}}" class="btn btn-small btn-info">
	  					<i class="btn-icon-only icon-ok"></i>
	  				</a>
	  				<a href="{{ route('pcat.edit' , $pcat->id)}}" class="btn btn-small btn-warning">
	  					<i class="btn-icon-only  icon-edit"></i>
	  				</a>
	  				
	  				{!! Form::open([
	  					'method'=>'delete',
	  					'route' => [ 'pcat.destroy', $pcat->id ] ,
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
