@extends('client.app')

@section('content')
	<div class="container login" ng-controller="ClientPasswordController as password" 
		ng-init="password.checkForgotPasswordLink('{!! $email !!}')" ng-cloak>
	
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div template-directive template-url="{!! route('client.login.password.enter_reset_code') !!}"></div>

		<div class="client-container form-style" ng-if="password.active_default">
			<div class="form-content" ng-if="!password.sent">
				<div class="title">Retrieve Password</div>
				<div class="alert alert-danger" ng-if="password.errors">
					<p ng-repeat="error in password.errors" > 
						{! error !}
					</p>
				</div>
				
				{!! Form::open(array('ng-submit' => 'password.clientForgotPassword($event)')) !!}
					<div class="input">
						<div class="icon">
							<i class="fa fa-user"></i>
						</div>
						{!! Form::text('username', ''
									, array(
											'class' => 'form-control'
										, 'ng-model' => 'password.record.username'
										, 'placeholder' => 'Email or Username'
										, 'autocomplete' => 'off'
									)
						)!!}
					</div>

					<div class="btn-container">
						{!! Form::button('Send'
								, array(
											'id' => 'proceed_btn'
										, 'class' => 'btn btn-blue btn-medium'
										, 'ng-if' => '!sent'
										, 'ng-click' => 'password.clientForgotPassword($event)'
								)
						) !!}

						{!! Html::link(route('client.login'), 'Cancel'
								, array(
									'class' => 'btn btn-gold btn-medium'
								)
						) !!}
					</div>
				{!! Form::close() !!}
			</div>

			<div class="form_content" ng-if="password.sent">
				{!! Form::open(
					array(
							'id' => 'redirect_form'
							, 'route' => 'client.login.reset_password'
							, 'method' => 'POST'
					)
				) !!}

					{!! Form::hidden('id', '') !!}
					{!! Form::hidden('reset_code', '') !!}

				{!! Form::close() !!}

				<div class="title" ng-if="!password.resent">Reset Code Sent</div>
				<div class="title" ng-if="password.resent">Reset Code Resent</div>

				<div class="alert alert-danger" ng-if="password.errors">
					<p ng-repeat="error in password.errors" > 
						{! error !}
					</p>
				</div>

				<div ng-if="!password.resent">
					<div class="roundcon">
						<i class="fa fa-check fa-5x img-rounded text-center"></i>
					</div>

					<p class="text">
						An email to reset your password has been sent to your email account.
					</p>
				</div>

				<div ng-if="password.resent">
					<div class="roundcon">
						<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
					</div>
						
					<p class="text">
						A new reset code has been sent to your email account.
					</p>
				</div>

				<div class="form-group">
					<small>Please check your inbox or your spam folder for the email. 
					<br />The email contains a reset code that you need to input below.</small>
				</div>

				{!! Form::open(array('ng-submit' => 'password.clientValidateCode($event)')) !!} 
					<div class="form-group">
						{!! Form::label(null, 'Enter Reset Code:') !!}

						{!! Form::text('reset_code', '',
							array(
								'class' => 'form-control'
								, 'ng-model' => 'password.record.reset_code'
								, 'ng-disabled' => 'password.password_set'
								, 'placeholder' => 'Reset Code'
								, 'autocomplete' => 'off'
							)
						) !!}
					</div>

					<div class="btn-container">
						{!! Form::button('Proceed'
							, array(
								'id' => 'proceed_btn'
								, 'class' => 'btn btn-blue btn-medium'
								, 'ng-if' => '!password.password_set'
								, 'ng-click' => 'password.clientValidateCode($event)'
							)
						) !!}

						{!! Form::button('Resend Code'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-if' => '!password.password_set'
								, 'ng-click' => 'password.clientResendCode()'
							)
						) !!}
					</div>

					<br />
					<a href="{!! route('client.login') !!}"><i class="fa fa-home"></i> Home</a>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	{!! Html::script('/js/client/controllers/client_password_controller.js') !!}
	{!! Html::script('/js/client/services/client_password_service.js') !!}
@stop