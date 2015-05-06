@extends('student.app')

@section('content')

<div class="container login" ng-init="show='{!! $show !!}'" ng-cloak>
  <div class="col-md-6 col-md-offset-3">
    <div class="form-style form-select-password">
      {!! Form::open(array('id' => 'redirect_form', 'method' => 'POST', 'route' => 'student.login.reset_password')) !!}
        {!! Form::hidden('username', $email, array('ng-model' => 'username')) !!}
        {!! Form::hidden('id', '', array('ng-model' => 'id')) !!}
        {!! Form::hidden('reset_code', '') !!}
      {!! Form::close() !!}

      {!! Form::open(array('id' => 'forgot_success_form')) !!}

        <div class="form_content">
          <div class="title" ng-if="!resent">Enter Reset Code</div>
          <div class="title" ng-if="resent">Reset Code Resent</div>

          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>

          <div ng-if="resent">
            <div class="roundcon">
              <i class="fa fa-refresh fa-5x img-rounded text-center"></i>
            </div>

            <p class="text">
              <strong>Success!</strong>
              <br /> A new email to reset your picture password has been sent to your email account. 
            </p>

            <div class="form-group">
              <small>Please check your inbox or your spam folder for the email. 
              <br />The email contains a reset code that you need to input below.</small>
            </div>
          </div>

          <div ng-if="!resent && show">
            <div class="roundcon">
              <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>

            <p class="text">
              Please enter the reset code to create your new picture password.
            </p>
          </div>

          <div class="form-group">
            {!! Form::text('reset_code', ''
                , array(
                    'class' => 'form-control'
                    , 'placeholder' => 'Reset Code' 
                    , 'ng-model' => 'reset_code'
                    , 'autocomplete' => 'off')
            ) !!}
          </div>

          <div class="btn-container">
            <a id="validate_code_btn" type="button" class="btn btn-maroon btn-medium" ng-click="studentValidateCode(reset_code)">PROCEED</a>
            <a type="button" ng-disabled="disabled" class="btn btn-gold btn-medium" ng-click="studentResendCode()">Resend Code</a>
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
