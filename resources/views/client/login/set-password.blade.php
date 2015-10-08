@extends('client.app')

@section('content')
	<div class="container login" ng-cloak>
			<div class="client-container form-style" ng-controller="LoginController as confirm"
				ng-init="confirm.setRegistrationStatus('{!! $email !!}')"> 
				<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
				
				<div ng-if="!confirm.confirmed">
					<div class="title">Thank you for registering to Future Lesson!</div>
			
					<div class="alert alert-danger" ng-if="confirm.errors">
						<p ng-repeat="error in confirm.errors" > 
							{! error !}
						</p>
					</div>
							
					<div class="form_content">
						<div ng-if="!confirm.resent">
							<div class="roundcon">
									<i class="fa fa-check fa-5x img-rounded text-center" ></i>
							</div>

							<p class="text">
									Please enter the confirmation code to confirm your email account.
							</p>
						</div>

						<div ng-if="confirm.resent">
							<div class="roundcon">
									<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
							</div>
							
							<p class="text">
									A new confirmation code has been sent to your email account.
							</p>
						</div>
							
							<br />
							<small>Please check your inbox or your spam folder for the email. The email contains a confirmation code that you need to input below.</small>
							{!! Form::open(array('ng-submit' => 'confirm.confirmClientRegistration($event)')) !!}
									<div class="form-group" ng-if="!confirm.account_confirmed">
											{!! Form::label('', 'Enter Confirmation Code:')!!}
											
											{!! Form::text('confirmation_code', ''
															, array(
																	'class' => 'form-control'
																	, 'placeholder' => 'Confirmation Code'
																	, 'ng-model' => 'confirm.record.email_code'
																	, 'autocomplete' => 'off'
															)
											) !!}

											{!! Form::hidden('email', $email) !!}
									</div>
									<div class="btn-container">
											{!! Form::button('Confirm'
													, array(
																'id' => 'proceed_btn'
															, 'class' => 'btn btn-blue btn-medium'
															, 'ng-click' => 'confirm.confirmClientRegistration($event)'
															, 'ng-if' => '!confirm.account_confirmed'
													)
											) !!}

											{!! Form::button('Resend'
													, array(
																'class' => 'btn btn-gold btn-medium'
															, 'ng-click' => 'confirm.resendClientConfirmation()'
															, 'ng-if' => '!confirm.account_confirmed'
													)
											)!!}
									</div>
									<br />
									<a href="{!! route('client.login') !!}"><i class="fa fa-home"></i> Home</a>
							{!! Form::close() !!}
					</div>
				</div>

				<div ng-if="confirm.confirmed && !confirm.success">
						<div class="title">Set New Password</div>

							<div class="alert alert-danger" ng-if="confirm.errors">
								<p ng-repeat="error in confirm.errors" > 
									{! error !}
								</p>
							</div>
							{!! Form::open(
									array(
											'id' => 'reset_password_form'
									)
							) !!}

							<div class="input">
								<div class="icon">
									<i class="fa fa-unlock-alt"></i>
								</div>
								{!! Form::password('new_password'
											, array(
													'ng-model' => 'confirm.record.new_password'
												, 'placeholder' => 'New Password'
											)
								) !!}
							</div>
							<div class="input">
								<div class="icon">
									<i class="fa fa-lock"></i>
								</div>
								{!! Form::password('confirm_password'
											, array(
													'ng-model' => 'confirm.record.confirm_password'
												, 'placeholder' => 'Confirm New Password'
											)
								) !!}
							</div>

							<div class="btn-container">
								{!! Form::button('Set Password'
										, array(
											'class' => 'btn btn-blue btn-large'
											, 'ng-click' => 'confirm.setNewClientPassword()'
										)
								) !!}
						 </div>
						{!! Form::close() !!}
				</div>

				<div ng-if="confirm.confirmed && confirm.success">
						<div class="title">Success!</div>

						<div class="roundcon">
							<i class="fa fa-check fa-5x img-rounded text-center"></i>
						</div>

						<p>Your password has been set.</p>
						<p> You may now use your new password to login.</p>

						<br />

						<div class="btn-container">
							<a class="btn btn-blue btn-large" href="{!! route('client.login') !!}">Click here to Login</a>
						</div>
				</div>
		</div>
	</div>
@endsection

@section('scripts')
	{!! Html::script('//connect.facebook.net/en_US/sdk.js') !!}
	{!! Html::script('https://apis.google.com/js/platform.js') !!}
	{!! Html::script('https://apis.google.com/js/client.js') !!}

	{!! Html::script('/js/common/validation_service.js')!!}

	{!! Html::script('/js/student/controllers/media_login_controller.js') !!}
	{!! Html::script('/js/student/services/media_login_service.js') !!}

	{!! Html::script('/js/client/controllers/login_controller.js') !!}
	{!! Html::script('/js/client/services/login_service.js') !!}
@stop