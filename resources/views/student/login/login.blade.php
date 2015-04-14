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
        <div>
          <form id="loginForm" name="loginForm" action="/student/login/enter-password" method="POST">
            <div class="title">Enter Your Username or Email</div>
              <div class="error" ng-if="error">
                <p>{! error !}</p>
              </div>

            <div class="form-group">
              <input type="text" class="form-control" name="username" ng-model="username" required>
              <input type="hidden" name="id" ng-model="id" required>
            </div>
            <div class="form-group">
              <button type="button" ng-click="validateUser(username)" class="btn btn-red">Next</button>              
            </div>
          </form>
        </div>
      <div class="text-group">
        <small>Not a Student?</small>
        <small>Click <a href="#">here</a> for Parent / Teacher / School Site</small>     
      </div>  
      <div class="text-group">
        <small><a ng-click="redirect('/student/login/forgot-password')">Forgot your password?</a></small>
        <p><a ng-click="redirect('/student/registration')" class="btn btn-purple">Sign Up</a></p>      
      </div>  
      </div>
    </div>
  </div>
</div>

@stop

@section('footer')

@overwrite

@section('scripts')
  
  <!-- {!! Html::script('/js/student/login.js') !!} -->

@stop
