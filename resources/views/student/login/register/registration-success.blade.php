<div class="login-container form-style" ng-if="login.active_registration_success">
	<div class="title" ng-if="!login.linked">{!! trans('messages.client_thank_you_for_register') !!}</div>
	<div class="title" ng-if="login.linked">{!! trans('messages.confirm_email_address') !!}</div>
		
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

				<small>{!! trans('messages.client_check_inbox') !!}</small>
			</div>
			
			<div ng-if="!login.resent && login.linked">
				<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
				</div>

				<p class="text" >
					{!! trans('messages.student_confirm_code_verify') !!}
				</p>
			</div>

			<div ng-if="login.resent">
				<div class="roundcon">
					<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
				</div>

				<p>
					{!! trans('messages.client_new_confirmation_code') !!}
				</p>
				<small>{!! trans('messages.client_check_inbox') !!}</small>
			</div>
		</div>
</div>