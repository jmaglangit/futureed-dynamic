@extends('admin.app')

@section('content')
	<div class="container login" ng-cloak>
		<div class="col-md-4 col-md-offset-4">
			<div class="form-style form-narrow">
				<!-- Display Errors -->
				<div style="display:none">
					<div class="title">
						Account Locked
					</div>
					<div class="form_content">
						<div class="lock-logo">
							<i class="fa fa-lock fa-5x img-rounded text-center icon-lock"></i>
						</div>
						<p>Your account has been locked due to maximum attemp of invalid login/</p>
						<p>Please <a href="#">click here</a> to redirect you to the steps to reset your password.</p>
					</div>
				</div>
				<div class="logo-container">
					{!! Html::image('images/logo-md.png') !!}
				</div>
				<div class="alert alert-danger" ng-if="errors">
					<p ng-repeat="error in errors">
						{! error !}
					</p>
				</div>
				{!! Form::open(
              array(
                    'id' => 'login_form'
                  , 'route' => 'client.login.process'
                  , 'method' => 'POST'
                  , 'ng-controller' => 'LoginController as login'
              )
          ) !!}
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            {!! Form::text('login', ''
                , array(
                    'placeholder' => 'Email or Username'
                    , 'ng-model' => 'login.username'
                    , 'autocomplete' => 'off'
                )
            ) !!}
          </div>
          <div class="input pass">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            {!! Form::password('password'
                , array(
                    'placeholder' => 'Password'
                    , 'ng-model' => 'login.password'
                )
            ) !!}
          </div>

          {!! Form::hidden('user_data', ''
              , array(
                 'ng-model' => 'user_data'
              )
          ) !!}

          {!! Form::button('Login'
              , array(
                  'class' => 'btn btn-blue'
                  , 'ng-click' => 'login.clientLogin()'
              )
          ) !!}
          	<div class="form-group">
          		<a href="{!! route('admin.login.forgot_password') !!}" style="color:#055A7F;">Forgot your Password?</a>
          	</div>
			</div>
		</div>
	</div>