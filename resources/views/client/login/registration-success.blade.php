<div class="register_users form-style col-sm-6 col-sm-offset-3" ng-if="registered && !success"> 
	<div class="title">Thank you for registering to Future Lesson!</div>
	<div class="error" ng-if="error">{! error !}</div>
	<div class="form_content">
		<div class="roundcon">
    		<i class="fa fa-check fa-5x img-rounded text-center"></i>
    	</div>
    	<p class="text" ng-if="!resent">
    		An email to reset your picture password has been sent to your email account.
    	</p>
    	<p class="text" ng-if="resent">
    		A new code has been sent to your email.
    	</p>
    	<small>Please check your inbox or your spam folder for the email. The email contains a code that you need to input below.</small>
        <form>
	        <div class="form-group">
	          	<label>Enter Code:</label>
	            <input type="text" class="form-control" ng-model="confirmation_code" name="confirmation_code" placeholder="Confirmation Code" />
	            <input type="hidden" name="email" value="{!! $email !!}" />
            </div>
	        <div class="btn-container">
	        	<button type="button" class="btn btn-blue btn-medium" ng-disabled="disabled" ng-click="confirmClientRegistration()">Confirm</button>
            	<button type="button" class="btn btn-gold btn-medium" ng-disabled="disabled" ng-click="resendClientConfirmation()">Resend</button>
	        </div>
        </form>
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