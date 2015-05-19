@extends('admin.app')

@section('content')
	<div class="container login" ng-controller="AdminLoginController as forgot" ng-cloak>

  <div template-directive template-url="{!! route('admin.base_url') !!}"></div>

		<div class="col-md-6 col-md-offset-3">
			<div class="form-style form-narrow">
				<div class="logo-container">
					{!! Html::image('images/logo-md.png') !!}
				</div>
        <div class="adlogin-title" ng-if="!sent">
          Forgot Password
        </div>
        <div class="adlogin-title" ng-if="sent">
          Password Reset
        </div>
        <div class="forgot-message" ng-if="sent">
          <p>An email to reset your password has been sent to your email account.Please check your inbox or your spam folder for email.</p><br/>
          <p>The email contains a code that you need to input below.</p>
        </div>
				<div class="alert alert-danger" ng-if="errors">
					<p ng-repeat="error in errors">
						{! error !}
					</p>
				</div>
        <div class="title-mid" ng-if="sent">
          Enter code
        </div>
				{!! Form::open(
              array(
                    'id' => 'forgot_pass_form'
                  , 'route' => 'admin.login.reset_password'
                  , 'method' => 'POST'
              )
          ) !!}
          {!! Form::hidden('id', '') !!}
          {!! Form::hidden('reset_code', '') !!}
          
          <div class="input" ng-if="!sent">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            {!! Form::text('username', ''
                , array(
                    'placeholder' => 'Email or Username'
                    , 'ng-model' => 'forgot.username'
                    , 'autocomplete' => 'off'
                )
            ) !!}
          </div>
          <div class="input" ng-if="sent">
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
          <div class="btn-container" ng-if="!sent">
            {!! Form::button('Send'
                , array(
                    'class' => 'btn btn-blue btn-medium'
                    , 'ng-click' => 'forgot.adminForgotPass()'
                )
            ) !!}

            {!! Html::link(route('admin.login'), 'Cancel'
                , array(
                  'class' => 'btn btn-gold btn-medium'
                )
            ) !!}
          </div>
          <div class="btn-container" ng-if="sent">
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
