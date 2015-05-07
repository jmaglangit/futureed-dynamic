<div class="register_users form-style col-sm-6 col-sm-offset-3" ng-if="registered && !success"> 
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
    	<p class="text" ng-if="!resent">
    		An email to reset your password has been sent to your email account.
    	</p>
    	<p class="text" ng-if="resent">
    		A new code has been sent to your email.
    	</p>
    	<small>Please check your inbox or your spam folder for the email. The email contains a code that you need to input below.</small>
        {!! Form::open(array('id' => 'registration_success_form')) !!}
	        <div class="form-group">
                {!! Form::label('', 'Enter Code:')!!}
                
                {!! Form::text('confirmation_code', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => 'Confirmation Code'
                            , 'ng-model' => 'confirmation_code'
                        )
                ) !!}
	            
                {!! Form::hidden('email', $email) !!}
            </div>
	        <div class="btn-container">
	        	<button type="button" class="btn btn-blue btn-medium" ng-disabled="disabled" ng-click="confirmClientRegistration()">Confirm</button>
            	<button type="button" class="btn btn-gold btn-medium" ng-disabled="disabled" ng-click="resendClientConfirmation()">Resend</button>
	        </div>
        {!! Form::close() !!}
    </div>
</div>

<div class="register_users form-style col-md-6 col-md-offset-3" ng-if="registered && success">
    <div class="title">Success!</div>
    <div class="form_content">
		<div class="roundcon">
	        <i class="fa fa-check fa-5x img-rounded text-center"></i>
	      </div>
    	<p class="text">
    		Your email account has been successfully verified.
    	</p>
    	<a class="btn btn-blue" href="{!! route('client.login') !!}">Click here to Login</a> 
    </div>  
</div>