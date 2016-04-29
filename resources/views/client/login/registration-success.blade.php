<div class="client-container form-style" ng-if="login.active_registration_success">
	
	<div ng-if="!login.confirmed">
		<div class="title" ng-if="!login.linked">{!! trans('messages.client_thank_you_for_register') !!}</div>
		<div class="title" ng-if="login.linked">{!! trans('messages.confirm_email_address') !!}</div>
		
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
				<small>{!! trans('messages.youre_almost_done') !!}</small>

				<p class="text" >
					{!! trans('messages.client_enter_confirm_code') !!}
				</p>
			</div>

			<div ng-if="login.resent">
				<div class="roundcon">
					<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
				</div>				

				<p>
					{!! trans('messages.client_new_confirmation_code') !!}
				</p>
				<small>{!! trans('messages.client_reset_code_msg') !!}</small>
			</div>
			
		</div>
	</div>

	<div ng-if="login.confirmed">
		<div class="title">
			<h3>{!! trans('messages.success') !!}!</h3>
		</div>

		<div class="form_content">
			<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
			</div>
			 
			<p>
				{!! trans('messages.client_registration_success_msg') !!}
			</p>

		</div>	
	</div> 
</div>