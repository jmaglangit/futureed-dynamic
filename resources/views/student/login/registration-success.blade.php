<div class="col-md-6 col-md-offset-3" ng-init="linked={!! $success !!}" ng-if="success" ng-cloak>
	<div class="form-style form-select-password">
		<div class="title" ng-if="!linked">Thank you for registering to Future Lesson!</div>
		<div class="title" ng-if="linked">Confirm Your Email Address</div>
		
		<div class="alert alert-danger" ng-if="errors">
          <p ng-repeat="error in errors" > 
            {! error !}
          </p>
        </div>
		
		<div class="form_content">
        	<div ng-if="!resent && success && !linked">
        		<div class="roundcon">
	        		<i class="fa fa-check fa-5x img-rounded text-center"></i>
	        	</div>

        		<p class="text" >
	        		A confirmation code has been sent to your email account.
	        	</p>

	        	<small>Please check your inbox or your spam folder for the email. The email contains a confirmation code that you need to input below.</small>
        	</div>
        	
        	<div ng-if="!resent && success && linked">
        		<div class="roundcon">
	        		<i class="fa fa-check fa-5x img-rounded text-center"></i>
	        	</div>

        		<p class="text" >
	        		Please enter the confirmation code to verify your email address and to setup your new picture password.
	        	</p>
        	</div>

        	<div ng-if="resent">
        		<div class="roundcon">
	        		<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
	        	</div>

        		<p ng-if="resent">
	        		A new confirmation code has been sent to your email account.
	        	</p>
	        	<small>Please check your inbox or your spam folder for the email. The email contains a confirmation code that you need to input below.</small>
        	</div>
        	{!! Form::open(array('id' => 'redirect_form', 'method' => 'POST', 'route' => 'student.login.set_password')) !!}
        		{!! Form::hidden('email', $email, array('ng-model' => 'email')) !!}
		        {!! Form::hidden('id', '', array('ng-model' => 'id')) !!}
		        {!! Form::hidden('confirmation_code', '') !!}
        	{!! Form::close() !!}

        	{!! Form::open(array('id' => 'registration_success_form')) !!}
	            <div class="form-group">
		          	{!! Form::label('', 'Enter Confirmation Code:') !!}
		            {!! Form::text('confirmation_code', '', 
		            	array(
		            		'ng-model' => 'confirmation_code'
		            		, 'placeholder' => 'Confirmation Code'
		            		, 'autocomplete' => 'off'
		            		, 'class' => 'form-control')
		            ) !!}
		        </div>
		        <div class="btn-container">
		        	<button id="confirm_registration_btn" type="button" class="btn btn-maroon btn-medium" ng-click="studentConfirmRegistration()">Confirm</button>
	            	<button type="button" class="btn btn-gold btn-medium" ng-click="studentResendConfirmation()">Resend</button>
		        </div>
	        {!! Form::close() !!}
	    </div>
    </div>
</div>