@extends('admin.app')

@section('content')
	<div class="container login" ng-controller="AdminLoginController as forgot" 
		ng-init="forgot.init('{!! route('admin.password.reset') !!}', '{!! $email !!}')" ng-cloak>

		<div template-directive template-url="{!! route('admin.base_url') !!}"></div>

		<div class="login-container form-style">
			{!! Form::open(
				array(
					'id' => 'redirect_form'
					, 'route' => 'admin.login.reset_password'
					, 'method' => 'POST'
				)
			) !!}
				{!! Form::hidden('id', '') !!}
				{!! Form::hidden('reset_code', '') !!}
			{!!Form::close() !!}

			<div class="adlogin-title">Password Reset</div>

			<div class="alert alert-danger" ng-if="forgot.errors">
				<p ng-repeat="error in forgot.errors">
					{! error !}
				</p>
			</div>

			<div ng-if="!forgot.resent">
				<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
				</div>

				<div class="forgot-message">
					<p>Please enter the reset code to create your new password.</p>
				</div>
			</div>

			<div ng-if="forgot.resent">
				<div class="roundcon">
					<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
				</div>

				<div class="forgot-message">
					<p>A new reset code has been sent to your email account.</p>

					<small>
						Please check your inbox or your spam folder for the email.
						The email contains a confirmation code that you need to input below.
					</small>
				</div>
			</div>

			<div class="title-mid">
				Enter code
			</div>

			{!! Form::open(array('ng-submit' => 'forgot.validateCode($event)')) !!}
				<div class="input">
					<div class="icon">
						<i class="fa fa-user"></i>
					</div>

					{!! Form::text('reset_code', ''
						, array(
							'placeholder' => 'Enter Code'
							, 'ng-model' => 'forgot.record.reset_code'
							, 'autocomplete' => 'off'
						)
					) !!}
				</div>
				
				<div class="btn-container">
					{!! Form::button('Proceed'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => 'forgot.validateCode($event)'
						)
					) !!}

					{!! Form::button('Resend Code'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => 'forgot.resendCode()'
						)
					) !!}
				</div>

				<br />
				<a href="{!! route('admin.login') !!}"><i class="fa fa-home"></i> Home</a>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	{!! Html::script('/js/admin/controllers/login_controller.js') !!}
	{!! Html::script('/js/admin/services/login_service.js') !!}
@stop
