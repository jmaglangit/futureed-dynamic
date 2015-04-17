<div class="col-md-6 col-md-offset-3" ng-if="success">
	<div class="form-style form-select-password">
		<div class="title">Thank you for registering to Future Lesson!</div>
		<div class="error" ng-if="error">{! error !}</div>
		<div class="form_content">
    		<div class="roundcon">
        		<i class="fa fa-check fa-5x img-rounded text-center"></i>
        	</div>
        	<p class="text">
        		An email to reset your picture password has been sent to your email account.
        	</p>
        	<small>Please check your inbox or your spam folder for the email. The email contains a code that you need to input below.</small>
	        <form name="success_form" id="success_form" 
            	  action="{!! route('student.login.reset_password') !!}" method="POST">
	          <div class="form-group">
	          	  <label for="reset_code">Enter Code:</label>
	              <input type="text" class="form-control" ng-model="reset_code" name="reset_code" placeholder="Verification Code" required />
	              <input type="hidden" ng-model="email" name="email" required />
	              <input type="hidden" ng-model="user_id" name="user_id" required />
	          </div>
            <button type="button" class="btn btn-red" ng-click="validateCode(reset_code)">Confirm</button>
	        </form>
	    </div>
    </div>
</div>