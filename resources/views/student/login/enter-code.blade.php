@extends('student.app')

@section('content')

<div class="container login" ng-cloak>
  <div class="col-md-6 col-md-offset-3">
    <div class="form-style form-select-password">
      <form name="success_form" id="success_form" 
            action="{!! route('student.login.reset_password') !!}" method="POST">
        <div class="form_content">
          <div class="title" ng-if="!resend">@if($show) Email Sent @else Enter Code @endif</div>
          <div class="title" ng-if="resend">Code Resent</div>

          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>

          <div ng-if="{!! $show !!}">
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
            </div>
            <div class="form-group">
              <input type="text" class="form-control" ng-model="reset_code" name="reset_code" placeholder="Reset Code" autocomplete="off" />
              <input type="hidden" ng-model="username" name="username" value="{!! $email !!}"/>
              <input type="hidden" ng-model="id" name="id" required />
            </div>
            <div class="btn-container">
              <a type="button" class="btn btn-red btn-medium" ng-click="studentValidateCode(reset_code)">PROCEED</a>
              <a type="button" ng-disabled="disabled" class="btn btn-purple btn-medium" ng-click="studentResendCode()">Resend Code</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  @endsection

  @section('footer')

  @overwrite

  @section('scripts')

  {!! Html::script('/js/student/login.js') !!}

  @stop