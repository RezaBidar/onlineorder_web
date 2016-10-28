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
		@foreach($users as $user)
	  		<tr>
	  			<td>{!! getAvatar($user->pic) !!}</td>
	  			<td>{{ $user->name }}</td>
	  			<td>{{ $user->username }}</td>
	  			<td>{{ $user->type }}</td>
	  			<td>{{ $user->tel }}</td>
	  			<td>
	  				<a href="{{ route('user.show' , $user->id)}}" class="btn btn-small btn-info">
	  					<i class="btn-icon-only icon-ok"></i>
	  				</a>
	  				<a href="{{ route('user.edit' , $user->id)}}" class="btn btn-small btn-warning">
	  					<i class="btn-icon-only  icon-edit"></i>
	  				</a>
	  				
	  				{!! Form::open([
	  					'method'=>'delete',
	  					'route' => [ 'user.destroy', $user->id ],
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
