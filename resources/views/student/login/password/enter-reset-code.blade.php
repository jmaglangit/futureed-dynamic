<div class="login-container form-style" ng-if="password.active_linked">
	<div class="title" ng-if="!password.linked">Enter Reset code</div>
	<div class="title" ng-if="password.linked">Confirm Your Email Address</div>
		
	<div class="alert alert-danger" ng-if="password.errors">
		<p ng-repeat="error in password.errors" > 
			{! error !}
		</p>
	</div>
	
	<div class="form_content">
		<div ng-if="!password.resent">
			<div class="roundcon">
				<i class="fa fa-check fa-5x img-rounded text-center"></i>
			</div>

			<p class="text" >
				Please enter the reset code to create your new picture password.
			</p>
		</div>

		<div ng-if="password.resent">
			<div class="roundcon">
				<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
			</div>

			<p>
				A new email to reset your picture password has been sent to your email account. 
			</p>
			<small>Please check your inbox or your spam folder for the email. The email contains a confirmation code that you need to input below.</small>
		</div>

		{!! Form::open(array('id' => 'redirect_form', 'method' => 'POST', 'route' => 'student.login.reset_password')) !!}
			{!! Form::hidden('id') !!}
			{!! Form::hidden('reset_code', '') !!}
		{!! Form::close() !!}

		{!! Form::open(array('ng-submit' => 'password.validateCode($event)')) !!}
			<div class="form-group">
				{!! Form::text('reset_code', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => 'Reset Code'
						, 'autocomplete' => 'off'
						, 'ng-disabled' => 'password.password_set'
						, 'ng-model' => 'password.record.reset_code'
					)
				) !!}
			</div>
			<div class="btn-container">
				{!! Form::button('Proceed'
					, array(
						  'class' => 'btn btn-maroon btn-medium'
						, 'ng-if' => '!password.password_set'
						, 'ng-click' => 'password.validateCode($event)'
					)
				) !!}

				{!! Form::button('Resend Code'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-if' => '!password.password_set'
						, 'ng-click' => 'password.resendResetCode()'
					)
				) !!}
			</div>
			
			<br />
			<a href="{!! route('student.login') !!}"><i class="fa fa-home"></i> Home</a>
		{!! Form::close() !!}
	</div>
</div>