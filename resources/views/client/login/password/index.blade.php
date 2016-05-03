@extends('client.app')

@section('content')
	<div class="container login" ng-controller="ClientPasswordController as password" 
		ng-init="password.checkForgotPasswordLink('{!! $email !!}')" ng-cloak>
	
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div template-directive template-url="{!! route('client.login.password.enter_reset_code') !!}"></div>

		<div class="client-container form-style" ng-if="password.active_default">
			<div class="form-content" ng-if="!password.sent">
				<div class="title">{!! trans('messages.client_retrieve_password') !!}</div>
				<div class="alert alert-danger" ng-if="password.errors">
					<p ng-repeat="error in password.errors" > 
						{! error !}
					</p>
				</div>
				
				{!! Form::open(array('ng-submit' => 'password.clientForgotPassword($event)')) !!}
					<div class="input">
						<div class="icon">
							<i class="fa fa-user"></i>
						</div>
						{!! Form::text('username', ''
									, array(
											'class' => 'form-control'
										, 'ng-model' => 'password.record.username'
										, 'placeholder' => trans('messages.email_or_username')
										, 'autocomplete' => 'off'
									)
						)!!}
					</div>

					<div class="btn-container">
						{!! Form::button(trans('messages.forgot_send')
								, array(
											'id' => 'proceed_btn'
										, 'class' => 'btn btn-blue btn-medium'
										, 'ng-if' => '!sent'
										, 'ng-click' => 'password.clientForgotPassword($event)'
								)
						) !!}

						{!! Html::link(route('client.login'), trans('messages.cancel')
								, array(
									'class' => 'btn btn-gold btn-medium'
								)
						) !!}
					</div>
				{!! Form::close() !!}
			</div>

			<div class="form_content" ng-if="password.sent">
				{!! Form::open(
					array(
							'id' => 'redirect_form'
							, 'route' => 'client.login.reset_password'
							, 'method' => 'POST'
					)
				) !!}

					{!! Form::hidden('id', '') !!}
					{!! Form::hidden('reset_code', '') !!}

				{!! Form::close() !!}

				<div class="title" ng-if="!password.resent">{!! trans('messages.client_reset_code_sent') !!}</div>
				<div class="title" ng-if="password.resent">{!! trans('messages.client_reset_code_resent') !!}</div>

				<div class="alert alert-danger" ng-if="password.errors">
					<p ng-repeat="error in password.errors" > 
						{! error !}
					</p>
				</div>

				<div ng-if="!password.resent">
					<div class="roundcon">
						<i class="fa fa-check fa-5x img-rounded text-center"></i>
					</div>

					<p class="text">
						{!! trans('messages.forgot_email_sent') !!}
					</p>
				</div>

				<div ng-if="password.resent">
					<div class="roundcon">
						<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
					</div>
						
					<p class="text">
						{!! trans('messages.forgot_new_code') !!}
					</p>
				</div>

				<div class="form-group">
					<small>{!! trans('messages.client_reset_code_msg') !!}</small>
				</div>

				{!! Form::open(array('ng-submit' => 'password.clientValidateCode($event)')) !!} 
					<div class="form-group">
						{!! Form::label(null, trans('messages.client_enter_reset_code')) !!}

						{!! Form::text('reset_code', '',
							array(
								'class' => 'form-control'
								, 'ng-model' => 'password.record.reset_code'
								, 'ng-disabled' => 'password.password_set'
								, 'placeholder' => trans('messages.client_reset_code')
								, 'autocomplete' => 'off'
							)
						) !!}
					</div>

					<div class="btn-container">
						{!! Form::button(trans('messages.client_proceed')
							, array(
								'id' => 'proceed_btn'
								, 'class' => 'btn btn-blue btn-medium'
								, 'ng-if' => '!password.password_set'
								, 'ng-click' => 'password.clientValidateCode($event)'
							)
						) !!}

						{!! Form::button(trans('messages.client_resend_code')
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-if' => '!password.password_set'
								, 'ng-click' => 'password.clientResendCode()'
							)
						) !!}
					</div>

					<br />
					<a href="{!! route('client.login') !!}"><i class="fa fa-home"></i> {!! trans('messages.forgot_home') !!}</a>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	{!! Html::script('/js/client/controllers/client_password_controller.js') !!}
	{!! Html::script('/js/client/services/client_password_service.js') !!}
@stop