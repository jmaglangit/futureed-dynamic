@extends('student.app')

@section('content')

  <div class="container login">
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style">
      	<!-- ERROR -->
      	<div style="display:none;">
	        <div class="title">Account Locked</div>
	        <div class="form_content">
	          <div style="width:120px; margin:0 auto 30px;">
	          <i class="fa fa-lock fa-5x img-rounded text-center" style="background:#e8e8e8; border-radius:200px; padding:20px; width:120px;"></i>
	          </div>
	
	          <p class="h4 text">Your account has been locked due to maximum attempt of invalid login.</p>
	          <small>Please <a href="#">click here</a> to redirect you to the steps to reset your password.</small>
	          <p style="padding-bottom: 40px;">
	            <a href="" class="btn btn-red">Reset Password</a>
	          </p>
	        </div>
      	</div>
		<!--// ERROR -->
		<div class="title">Enter Your Username or Email</div>
      <div class="error">
        <p>Email or Username should not be empty</p>
      </div>
      <form action="">
        <div class="form-group">
          <input class="form-control" type="email" name="" id="">              
        </div>
        <div class="form-group">
          <a href="login_step2.shtml.html" class="btn btn-red">Next</a>              
        </div>
      </form>
      <div class="text-group">
        <small>Not a Student?</small>
        <small>Click <a href="#">here</a> for Parent / Teacher / School Site</small>     
      </div>  
      <div class="text-group">
        <small><a href="forgot-password.shtml.html">Forgot yor password</a></small>
        <p><a href="student-registration.shtml.html" class="btn btn-purple">Sign Up</a></p>      
      </div>  
      </div>
    </div>
  </div>

@stop

@section('footer')
  
@overwrite

@section('scripts')
  


@stop
