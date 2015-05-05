<div class="col-md-6 col-md-offset-3" ng-if="success">
	<div class="form-style form-select-password">
		<div class="title">Thank you for registering to Future Lesson!</div>
		
		<div class="alert alert-danger" ng-if="errors">
          <p ng-repeat="error in errors" > 
            {! error !}
          </p>
        </div>
		
		<div class="form_content">
    		<div class="roundcon">
        		<i class="fa fa-check fa-5x img-rounded text-center"></i>
        	</div>

        	<div ng-if="!resent && !{!! $success !!}">
        		<p class="text" >
	        		An email to reset your picture password has been sent to your email account.
	        	</p>
	        	<small>Please check your inbox or your spam folder for the email. The email contains a code that you need to input below.</small>
        	</div>
        	
        	<p ng-if="resent">
        		A new code has been sent to your email.
        	</p>

        	{!! Form::open(array('id' => 'registration_success_form', 'method' => 'POST', 'route' => 'student.login.set_password')) !!}
	            <div class="form-group">
		          	<label>Enter Code:</label>
		            {!! Form::text('confirmation_code', $email, 
		            	array(
		            		'ng-model' => 'confirmation_code'
		            		, 'placeholder' => 'Confirmation Code'
		            		, 'class' => 'form-control')
		            ) !!}

		            {!! Form::hidden('email', $email, array('ng-model' => 'email')) !!}
		            {!! Form::hidden('id', '', array('ng-model' => 'id')) !!}
		        </div>
		        <div class="btn-container">
		        	<button type="button" class="btn btn-maroon btn-medium" ng-click="studentConfirmRegistration()">Confirm</button>
	            	<button type="button" class="btn btn-gold btn-medium" ng-click="studentResendConfirmation()">Resend</button>
		        </div>
	        {!! Form::close() !!}
	    </div>
    </div>
</div>