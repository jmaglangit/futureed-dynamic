<div class="client-container form-style" ng-if="password.active_linked">
	<div class="title" ng-if="!password.resent">{!! trans('messages.client_enter_reset_code') !!}</div>
	<div class="title" ng-if="password.resent">{!! trans('messages.client_reset_code_resent') !!}</div>
		
	<div class="alert alert-danger" ng-if="password.errors">
		<p ng-repeat="error in password.errors" > 
			{! error !}
		</p>
	</div>
	
	<div class="form_content">
		<div ng-if="!password.resent">
			<div class="roundcon">
				<i class="fa fa-check fa-5x img-rounded text-center"></i>
			</div>

			<p class="text" >
				{!! trans('messages.forgot_reset') !!}
			</p>
		</div>

		<div ng-if="password.resent">
			<div class="roundcon">
				<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
			</div>

			<p>
				{!! trans('messages.forgot_new_code') !!}
			</p>
			<small>{!! trans('messages.forgot_check_inbox') !!}</small>
		</div>

		{!! Form::open(array('id' => 'redirect_form', 'method' => 'POST', 'route' => 'client.login.reset_password')) !!}
			{!! Form::hidden('id') !!}
			{!! Form::hidden('reset_code', '') !!}
		{!! Form::close() !!}

		{!! Form::open(array('ng-submit' => 'password.clientValidateCode($event)')) !!}
			<div class="form-group">
				{!! Form::text('reset_code', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => 'trans('messages.client_reset_code')'
						, 'autocomplete' => 'off'
						, 'ng-disabled' => 'password.password_set'
						, 'ng-model' => 'password.record.reset_code'
					)
				) !!}
			</div>
			<div class="btn-container">
				{!! Form::button('trans('messages.client_proceed')'
					, array(
						  'class' => 'btn btn-blue btn-medium'
						, 'ng-if' => '!password.password_set'
						, 'ng-click' => 'password.clientValidateCode($event)'
					)
				) !!}

				{!! Form::button('trans('messages.client_resend_code')'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-if' => '!password.password_set'
						, 'ng-click' => 'password.clientResendCode()'
					)
				) !!}
			</div>
			
			<br />
			<a href="{!! route('student.login') !!}"><i class="fa fa-home"></i> {!! trans('messages.forgot_home') !!}</a>
		{!! Form::close() !!}
	</div>
</div>