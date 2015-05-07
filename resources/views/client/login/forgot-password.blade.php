@extends('client.app')

@section('content')
  <div class="container login" ng-cloak>

    <div class="col-md-6 col-md-offset-1" ng-init="sent={!! $sent !!}" ng-show="!sent">
      <div class="form-style form-narrow">
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
            {!! Form::text('username', ''
                  , array(
                      'class' => 'form-control'
                    , 'ng-model' => 'username'
                    , 'placeholder' => 'Email or Username'
                    , 'autocomplete' => 'off'
                  )
            )!!}
          </div>

          <div class="btn-container">
            <a type="button" class="btn btn-blue btn-medium" ng-click="clientForgotPassword()"> SEND </a>
            <a type="button" class="btn btn-gold btn-medium" href="{!! route('client.login') !!}"> Cancel </a>
          </div>
        {!! Form::close() !!}
      </div>
    </div>

    <div class="col-md-6 col-md-offset-1 form-style" ng-if="sent">
      {!! Form::open(array('id' => 'forgot_success_form', 'route' => 'client.login.reset_password', 'method' => 'POST')) !!}
        <div class="form_content">
          <div class="title" ng-if="!resend && sent">Email Sent</div>
          <div class="title" ng-if="resend && sent">Code Resent</div>

          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>

          <div ng-if="!resend && !'{!! $email !!}'">
            <div class="roundcon">
              <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>
            <div>
              <p class="text" ng-if="sent">
                <strong>Success!</strong>
                <br /> An email to reset your password has been sent to your email account.
              </p>
            
              <br />
              <div class="form-group">
                <small>Please check your inbox or your spam folder for the email. 
                <br />The email contains a code that you need to input below.</small>
                </div>
              </div>
            </div>
            <p ng-if="resend">
              A new code has been sent to your email.
            </p>
            <div class="form-group">
              {!! Form::label(null, 'Enter Code:') !!}

              {!! Form::text('reset_code', '',
                    array(
                        'class' => 'form-control'
                      , 'ng-model' => 'reset_code'
                      , 'placeholder' => 'Reset Code'
                      , 'autocomplete' => 'off'
                    )
              ) !!}

              {!! Form::hidden('username', $email
                    , array(
                        'ng-model' => 'username'
                    )
              ) !!}

              {!! Form::hidden('id', ''
                  , array(
                      'ng-model' => 'id'
                  )
              ) !!}
            </div>
            <div class="btn-container">
              <a type="button" ng-disabled="disabled" class="btn btn-blue btn-medium" ng-click="clientValidateCode(reset_code)">PROCEED</a>
              <a type="button" ng-disabled="disabled" class="btn btn-gold btn-medium" ng-click="clientResendCode()"> Resend Code </a>
            </div>
            
          </div>
        {!! Form::close() !!}
      </div>


  </div>
@endsection