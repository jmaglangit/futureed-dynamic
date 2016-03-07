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
			<div ng-if="!login.linked">
				<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
				</div>

				<small>You're almost done! We just need you to confirm you email address.</small>

				<p class="text" >
					Please check your inbox and click on the link.
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


		</div>
	</div>
</div>