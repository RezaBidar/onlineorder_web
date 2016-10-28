<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>ورود به سیستم سفارش آنلاین</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('css/bootstrap-responsive.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::asset('css/font-awesome.css') }}" rel="stylesheet">
    <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet"> -->
    
<link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('css/pages/signin.css') }}" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			
			<a class="brand pull-right" style="float:right" href="#">
				نرم افزار سفارش آنلاین پخشیار				
			</a>		
			
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->



<div class="account-container">
	
	<div class="content clearfix">
		
		<form action="#" method="post">
			{{ csrf_field() }}

			<h1>ورود اعضا</h1>		
			
			<div class="login-fields">
				
				<p>لطفا اطلاعات خود را وارد نمایید</p>
				
				<div class="field">
					<label for="username">نام کاربری :</label>
					<input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">رمز عبور :</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				
									
				<input type="submit" value="ورود" class="button btn btn-success btn-large" />
				<a  href="#" style="margin-right:2px;" class="button btn btn-info btn-large">ثبت نام</a>		

				<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">مرا به خاطر بسپار</label>
				</span>
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->



<div class="login-extra">
	<a href="#">بازیابی رمز عبور</a>
</div> <!-- /login-extra -->


<script src="{{ URL::asset('js/jquery-1.7.2.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.js') }}"></script>

<script src="{{ URL::asset('js/signin.js') }}"></script>

</body>

</html>
