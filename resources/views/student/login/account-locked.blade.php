	
	<div ng-show="locked">
		<div class="title">Account Locked</div>
		<div class="form_content">
			<div style="width:120px; margin:0 auto 30px;">
				<i class="fa fa-lock fa-5x img-rounded text-center" style="background:#e8e8e8; border-radius:200px; padding:20px; width:120px;"></i>
			</div>
			<p class="h4 text">Your account has been locked due to maximum attempt of invalid login.</p>	
			<small>Please <a href="#">click here</a> to redirect you to the steps to reset your password.</small>
			<div class="error" ng-if="error">
				<p>{! error !}</p>
			</div>
		    <a href="" ng-click="forgotPassword(username)" class="btn btn-red">Reset Password</a>
		</div>
	</div>
