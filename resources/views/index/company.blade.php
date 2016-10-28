@extends('templates.main')

@section('content_title' , 'لیست کاربران سایت')
@section('panel_size' , 'span12')

@section('content')
<div class="table-responsive">
	<table class="table table-hover table table-bordered" style="">
		<thead>
			<tr>
				<th>عکس</th>
				<th>نام</th>
				<th>نام کاربری</th>
				<th>نوع</th>
				<th>شماره تلفن</th>
				<th>مشاهده - ویرایش - حذف</th>
			</tr>
		</thead>
		<tbody>
		@foreach($companies as $company)
	  		<tr>
	  			<td>{!! getAvatar($company->pic) !!}</td>
	  			<td>{{ $company->name }}</td>
	  			<td>{{ $company->username }}</td>
	  			<td>{{ $company->type }}</td>
	  			<td>{{ $company->tel }}</td>
	  			<td>
	  				<a href="{{ route('company.show' , $company->id)}}" class="btn btn-small btn-info">
	  					<i class="btn-icon-only icon-ok"></i>
	  				</a>
	  				<a href="{{ route('company.edit' , $company->id)}}" class="btn btn-small btn-warning">
	  					<i class="btn-icon-only  icon-edit"></i>
	  				</a>
	  				
	  				{!! Form::open([
	  					'method'=>'delete',
	  					'route' => [ 'company.destroy', $company->id ] ,
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
