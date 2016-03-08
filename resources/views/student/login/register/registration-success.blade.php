<div class="login-container form-style" ng-if="login.active_registration_success">
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
					A confirmation has been sent to your email account.
				</p>

				<small>You're almost done! We just need you to confirm you email address. Please check your inbox and click on the link.</small>
			</div>
			
			<div ng-if="!login.resent && login.linked">
				<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
				</div>

				<p class="text" >
					Please enter the confirmation code to verify your email address and to setup your new picture password.
				</p>
			</div>

			<div ng-if="login.resent">
				<div class="roundcon">
					<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
				</div>

				<p>
					A new confirmation has been sent to your email account.
				</p>
				<small>You're almost done! We just need you to confirm you email address. Please check your inbox and click on the link.</small>
			</div>

		</div>
</div>