@extends('admin.app')

@section('content')
  <div class="container login" ng-controller="AdminLoginController as forgot" ng-cloak>
    <div class="login-container col-md-6 col-md-offset-3">
      <div class="form-style form-narrow">
        <div class="logo-container">
          {!! Html::image('images/logo-md.png') !!}
        </div>
        <div class="adlogin-title">
          Password Reset
        </div>
        <div class="roundcon" ng-if="!resent">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
        </div>

        <div class="roundcon" ng-if="resent">
            <i class="fa fa-refresh fa-5x img-rounded text-center"></i>
          </div>
        <div class="forgot-message" ng-if="!resent">
          <p>An email to reset your password has been sent to your email account.Please check your inbox or your spam folder for email.</p><br/>
          <p>The email contains a code that you need to input below.</p>
        </div>
        <div class="forgot-message" ng-if="resent">
          <p> A new reset code has been sent to your email account.Please check your inbox or your spam folder for email.</p><br/>
          <p>The email contains a code that you need to input below.</p>
        </div>
        <div class="alert alert-danger" ng-if="errors">
          <p ng-repeat="error in errors">
            {! error !}
          </p>
        </div>
        <div class="title-mid">
          Enter code
        </div>
        {!! Form::open(
              array(
                    'id' => 'redirect_form'
                  , 'route' => 'admin.login.reset_password'
                  , 'method' => 'POST'
              )
          ) !!}
          {!! Form::hidden('id', '') !!}
          {!! Form::hidden('email', $email) !!}
          {!! Form::hidden('reset_code', '') !!}

        {!! Form::close() !!}

        {!! Form::open([
              'id' => 'forgot_password_form'
              ])
            !!}
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            {!! Form::text('reset_code', ''
                , array(
                    'placeholder' => 'Enter Code'
                    , 'ng-model' => 'forgot.reset_code'
                    , 'autocomplete' => 'off'
                )
            ) !!}
          </div>
          <div class="btn-container">
            {!! Form::button('Proceed'
                , array(
                    'class' => 'btn btn-blue btn-medium'
                    , 'ng-click' => 'forgot.adminValidateCode(forgot.reset_code)'
                )
            ) !!}

            {!! Form::button('Resend Code'
                  , array(
                        'class' => 'btn btn-gold btn-medium'
                      , 'ng-click' => 'forgot.adminResendCode()'
                  )
              ) !!}
          </div>
      </div>
    </div>
  </div>
  @endsection

@section('scripts')
  {!! Html::script('/js/admin/controllers/login_controller.js') !!}
  {!! Html::script('/js/admin/services/login_service.js') !!}
  {!! Html::script('/js/admin/login.js') !!}
@stop