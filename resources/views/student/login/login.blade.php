@extends('student.app')

@section('content')
  <div class="container login student-fnt" ng-cloak>
    <div ng-class="{ 'col-md-8 col-md-offset-2': enter_pass && !locked, 'col-md-6 col-md-offset-3': !enter_pass || locked }" >
      <div class="form-style">
        @include('student.login.account-locked')
        @include('student.login.enter-password')

        <div ng-show="!locked && !enter_pass">
          <form id="login_form" name="login_form" method="POST">
          <div class="logo-container">
              <img src="/images/logo-md.png" />
            </div>
            <div class="login-title">Student Login</div>
            <div class="title">Login your Username and Password</div>
            <div class="error" ng-if="error">
              <p>{! error !}</p>
            </div>

            <div class="input">
              <div class="icon">
                <i class="fa fa-user"></i>                
              </div>
              <input type="text" class="form-control" name="username" ng-model="username" autocomplete="off" placeHolder="Email or Username" required>              
            </div>
            <div class="form-group">
              <button type="button" ng-click="validateUser()" class="btn btn-maroon">Next</button>              
            </div>
          </form>
          <div class="text-group">
            <small>Not a Student?</small>
            <small>Click <a href="{!! route('client.login') !!}">here</a> for Parent / Teacher / School Site</small>     
          </div>  
          <div class="text-group">
            <small><a href="{!! route('student.login.forgot_password') !!}" class="student-forgot">Forgot your password?</a></small>
            <p><a href="{!! route('student.registration') !!}" class="btn btn-yellow">Sign Up</a></p>      
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!} 

@stop
