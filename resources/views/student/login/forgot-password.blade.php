@extends('student.app')

@section('content')
  <div class="container login" ng-cloak>
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style" ng-show="!sent">
        <div class="title">Retrieve Password</div>
        <div class="alert alert-danger" ng-if="errors">
          <p ng-repeat="error in errors" > 
            {! error !}
          </p>
        </div>

        {!! Form::open() !!}
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <input placeholder="Username or Email" type="text" class="form-control" name="username" ng-model="username" autocomplete="off" />
          </div>
          <div class="btn-container">
            <a type="button" class="btn btn-red btn-medium" ng-click="studentForgotPassword()">SEND</a>
            <a href="{!! route('student.login') !!}" class="btn btn-purple btn-medium">Cancel</a>
          </div>
        {!! Form::close() !!}
      </div>

      <div class="form-style" ng-if="sent">
      {!! Form::open(array('id' => 'success_form', 'method' => 'POST', 'route' => 'student.login.reset_password')) !!}
        <div class="form_content">
          <div class="title" ng-if="!resend && sent">Email Sent</div>
          <div class="title" ng-if="resend && sent">Code Resent</div>

          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>

            <div class="roundcon">
              <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>
            <p class="text">
              <strong>Success!</strong>
              <br /> An email to reset your password has been sent to your email account. 
            </p>
            <div class="form-group">
              <small>Please check your inbox or your spam folder for the email. 
              <br />The email contains a code that you need to input below.</small>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" ng-model="reset_code" name="reset_code" placeholder="Reset Code" autocomplete="off" />
              <input type="hidden" ng-model="id" name="id" required />
            </div>
            <div class="btn-container">
              <button type="button" class="btn btn-red btn-medium" ng-click="studentValidateCode(reset_code)">PROCEED</button>
              <button type="button" class="btn btn-purple btn-medium" ng-click="studentResendCode()">Resend Code</button>  
            </div>
            
          </div>
        {!! Form::close() !!}
      </div>

    </div>
  </div>
@endsection

@section('footer')

@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop