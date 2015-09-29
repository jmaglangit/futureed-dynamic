<div class="client-container form-style" ng-if="password.active_linked">
	<div class="title" ng-if="!password.resent">Enter Reset Code</div>
	<div class="title" ng-if="password.resent">Reset Code Resent</div>
		
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
				Please enter the reset code to create your new password.
			</p>
		</div>

		<div ng-if="password.resent">
			<div class="roundcon">
				<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
			</div>

			<p>
				A new reset code has been sent to your email account.
			</p>
			<small>Please check your inbox or your spam folder for the email. The email contains a confirmation code that you need to input below.</small>
		</div>

		{!! Form::open(array('id' => 'redirect_form', 'method' => 'POST', 'route' => 'client.login.reset_password')) !!}
			{!! Form::hidden('id') !!}
			{!! Form::hidden('reset_code', '') !!}
		{!! Form::close() !!}

		{!! Form::open(array('ng-submit' => 'password.clientValidateCode($event)')) !!}
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
						  'class' => 'btn btn-blue btn-medium'
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
			<a href="{!! route('student.login') !!}"><i class="fa fa-home"></i> Home</a>
		{!! Form::close() !!}
	</div>
</div>