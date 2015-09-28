<div class="client-container form-style" ng-if="login.active_registration_success">
	
	<div ng-if="!login.confirmed">
		<div class="title" ng-if="!login.linked">Thank you for registering to Future Lesson!</div>
		<div class="title" ng-if="login.linked">Confirm Your Email Address</div>
		
		<div class="alert alert-danger" ng-if="login.errors">
			<p ng-repeat="error in login.errors" > 
				{! error !}
			</p>
		</div>
		
		<div class="form_content">
			<div ng-if="!login.resent && !login.linked">
				<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
				</div>

				<p class="text" >
					A confirmation code has been sent to your email account.
				</p>

				<small>Please check your inbox or your spam folder for the email. The email contains a confirmation code that you need to input below.</small>
			</div>
			
			<div ng-if="!login.resent && login.linked">
				<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
				</div>

				<p class="text" >
					Please enter the confirmation code to verify your email address and to setup your new password.
				</p>
			</div>

			<div ng-if="login.resent">
				<div class="roundcon">
					<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
				</div>

				<p>
					A new confirmation code has been sent to your email account.
				</p>
				<small>Please check your inbox or your spam folder for the email. The email contains a confirmation code that you need to input below.</small>
			</div>

			{!! Form::open(array('id' => 'registration_success_form', 'ng-submit' => 'login.confirmClientRegistration($event)')) !!}
				<div class="form-group">
					{!! Form::label('', 'Enter Confirmation Code:') !!}
					{!! Form::text('email_code', '', 
						array(
							'ng-model' => 'login.record.email_code'
							, 'placeholder' => 'Confirmation Code'
							, 'autocomplete' => 'off'
							, 'class' => 'form-control')
					) !!}
				</div>
				<div class="btn-container">
					{!! Form::button('Confirm'
							, array(
										'id' => 'proceed_btn'
									, 'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => 'login.confirmClientRegistration($event)'
									, 'ng-if' => '!login.account_confirmed'
							)
					) !!}

					{!! Form::button('Resend'
							, array(
										'class' => 'btn btn-gold btn-medium'
									, 'ng-click' => 'login.resendClientConfirmation()'
									, 'ng-if' => '!login.account_confirmed'
							)
					)!!}
				</div>
				<br />
				<a href="{!! route('client.login') !!}"><i class="fa fa-home"></i> Home</a>
			{!! Form::close() !!}
		</div>
	</div>

	<div ng-if="login.confirmed">
		<div class="title">
			<h3>Success!</h3>
		</div>

		<div class="form_content">
			<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
			</div>

			<p>
				Your email account has been successfully confirmed.
			</p>

			<h4 class="title">
					You will be receiving an email shortly by our Admin if your registration has been approved or not.
			</h4>
			<small> 
					If you have not yet receive the email, please check your inbox or your spam folder.
			</small>

			<div class="form-group">
				{!! Html::link(route('client.login'), 'Click here to Login'
						, array(
								'class' => 'btn btn-blue'
						) 
				) !!}
			</div>
		</div> 
	</div> 
</div>