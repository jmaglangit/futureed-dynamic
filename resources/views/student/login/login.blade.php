@extends('student.app')

@section('content')
  <div class="container login" ng-cloak>
    <div ng-class="{ 'col-md-8 col-md-offset-2': enter_pass && !locked, 'col-md-6 col-md-offset-3': !enter_pass || locked }" >
      <div class="form-style">
        @include('student.login.account-locked')
        @include('student.login.enter-password')

        <div ng-show="!locked && !enter_pass">
          {!! Form::open(array('id' => 'login_form', 'method' => 'POST')) !!}
            <div class="logo-container">
              {!! Html::image('images/logo-md.png') !!}
            </div>
            <div class="title">Enter Your Username or Email</div>

            <div class="alert alert-danger" ng-if="errors">
              <p ng-repeat="error in errors" > 
                {! error !}
              </p>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="username" ng-model="username" autocomplete="off" />
            </div>
            <div class="form-group">
              <button type="button" ng-click="validateUser()" class="btn btn-red">Next</button>              
            </div>
          {!! Form::close() !!}
          <div class="text-group">
            <small>Not a Student?</small>
            <small>Click <a href="{!! route('client.login') !!}">here</a> for Parent / Teacher / School Site</small>     
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
