@extends('admin.app')

@section('content')
	<div class="container login" ng-cloak>
		<div class="col-md-4 col-md-offset-4">
			<div class="form-style form-narrow">
				<div class="logo-container">
					{!! Html::image('images/logo-md.png') !!}
				</div>
        <div class="adlogin-title" ng-if="!forgot">
          Forgot Password
        </div>
        <div class="adlogin-title" ng-if="forgot">
          Password Reset
        </div>
        <div class="forgot-message" ng-if="forgot">
          <p>An email to reset your password has been sent to your email account.Please check your inbox or your spam folder for email.</p><br/>
          <p>The email contains a code that you need to input below.</p>
        </div>
				<div class="alert alert-danger" ng-if="errors">
					<p ng-repeat="error in errors">
						{! error !}
					</p>
				</div>
        <div class="title-code" ng-if="forgot">
          Enter code
        </div>
				{!! Form::open(
              array(
                    'id' => 'login_form'
                  , 'route' => 'client.login.process'
                  , 'method' => 'POST'
              )
          ) !!}
          <div class="input" ng-if="!forgot">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            {!! Form::text('login', ''
                , array(
                    'placeholder' => 'Email or Username'
                    , 'ng-model' => 'username'
                    , 'autocomplete' => 'off'
                )
            ) !!}
          </div>
          <div class="input" ng-if="forgot">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            {!! Form::text('reset_code', ''
                , array(
                    'placeholder' => 'Enter Code'
                    , 'ng-model' => 'reset_code'
                    , 'autocomplete' => 'off'
                )
            ) !!}
          </div>

          {!! Form::button('Send'
              , array(
                  'class' => 'btn btn-blue'
              )
          ) !!}
			</div>
		</div>
	</div>