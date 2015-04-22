@extends('student.app')

@section('content')
  <div class="container login" ng-cloak>
    <div ng-class="{ 'col-md-8 col-md-offset-2': enter_pass && !locked, 'col-md-6 col-md-offset-3': !enter_pass || locked }" >
      <div class="form-style">
        @include('student.login.account-locked')
        @include('student.login.enter-password')

        <div ng-show="!locked && !enter_pass">
          <form id="login_form" name="loginForm" method="POST">
            <div class="title">Enter Your Username or Email</div>
            <div class="error" ng-if="error">
              <p>{! error !}</p>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="username" ng-model="username" autocomplete="off" required>
              <input type="hidden" name="id" ng-model="id" required>
            </div>
            <div class="form-group">
              <button type="button" ng-click="validateUser(username)" class="btn btn-red">Next</button>              
            </div>
          </form>
          <div class="text-group">
            <small>Not a Student?</small>
            <small>Click <a href="#">here</a> for Parent / Teacher / School Site</small>     
          </div>  
          <div class="text-group">
            <small><a href="{!! route('student.login.forgot_password') !!}">Forgot your password?</a></small>
            <p><a href="{!! route('student.registration') !!}" class="btn btn-purple">Sign Up</a></p>      
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
