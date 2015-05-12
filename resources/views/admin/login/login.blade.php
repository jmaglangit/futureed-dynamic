@extends('admin.app')

@section('content')
	<div class="container login" ng-cloak>
		<div class="col-md-6 col-md-offset-3">
			<div class="form-style form-narrow">
				<!-- Display Errors -->
				<div style="display:none">
					<div class="title">
						Account Locked
					</div>
					<div class="form_content">
						<div class="lock-logo">
							<i class="fa fa-lock fa-5x img-rounded text-center icon-lock"></i>
						</div>
						<p>Your account has been locked due to maximum attemp of invalid login/</p>
						<p>Please <a href="#">click here</a> to redirect you to the steps to reset your password.</p>
					</div>
				</div>
				<div class="title-image">
					Login to your account
				</div>
				<div class="alert alert-danger" ng-if="errors">
					<p ng-repeat="error in errors">
						{! error !}
					</p>
				</div>
			</div>
		</div>
	</div>