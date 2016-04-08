@extends('admin.app')

@section('content')
	<div class="container login" ng-controller="AdminLoginController as forgot" 
		ng-init="forgot.init('{!! route('admin.password.reset') !!}')" ng-cloak>

		<div template-directive template-url="{!! route('admin.base_url') !!}"></div>

		<div class="login-container form-style">
			<div ng-if="!forgot.sent">
				<div class="logo-container">
					{!! Html::image('images/logo-md.png') !!}
				</div>

				<br />
				<div class="alert alert-danger" ng-if="forgot.errors">
					<p ng-repeat="error in forgot.errors">
						{! error !}
					</p>
				</div>

				<div class="adlogin-title">{!! trans('messages.admin_forgot_password') !!}</div>

				{!! Form::open(array('ng-submit' => 'forgot.forgotPassword($event)')) !!}
				<div class="input">
					<div class="icon">
						<i class="fa fa-user"></i>
					</div>

					{!! Form::text('username', ''
						, array(
							'placeholder' => trans('messages.email_or_username')
							, 'ng-model' => 'forgot.username'
							, 'autocomplete' => 'off'
						)
					) !!}
				</div>
				{!! Form::close() !!}

				<div class="btn-container">
					<button type="button" class="btn btn-blue btn-medium"
						ng-click="forgot.forgotPassword($event)">
						{!! trans('messages.forgot_send') !!}
					</button>

					{!! Html::link(route('admin.login'), trans('messages.cancel')
							, array(
								'class' => 'btn btn-gold btn-medium'
							)
					) !!}
				</div>
			</div>
			
			<div ng-if="forgot.sent">
				{!! Form::open(
					array(
						'id' => 'redirect_form'
						, 'route' => 'admin.login.reset_password'
						, 'method' => 'POST'
					)
				) !!}
					{!! Form::hidden('id', '') !!}
					{!! Form::hidden('reset_code', '') !!}
				{!!Form::close() !!}

				<div class="adlogin-title">{!! trans('messages.admin_password_reset') !!}</div>

				<div class="alert alert-danger" ng-if="forgot.errors">
					<p ng-repeat="error in forgot.errors">
						{! error !}
					</p>
				</div>

				<div ng-if="!forgot.resent">
					<div class="roundcon">
						<i class="fa fa-check fa-5x img-rounded text-center"></i>
					</div>

					<div class="forgot-message">
						<p>{!! trans('messages.forgot_email_sent') !!}</p>
						
						<small>						
							{!! trans('messages.forgot_check_inbox') !!}
						</small>
					</div>
				</div>

				<div ng-if="forgot.resent">
					<div class="roundcon">
						<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
					</div>

					<div class="forgot-message">
						<p>{!! trans('messages.forgot_new_code') !!}</p>

						<small>
							{!! trans('messages.forgot_check_inbox') !!}
						</small>
					</div>
				</div>

				<div class="title-mid">
					{!! trans('messages.admin_forgot_enter_code') !!}					
				</div>

				{!! Form::open(array('ng-submit' => 'forgot.validateCode($event)')) !!}
					<div class="input">
						<div class="icon">
							<i class="fa fa-user"></i>
						</div>

						{!! Form::text('reset_code', ''
							, array(
								'placeholder' => trans('messages.admin_forgot_enter_code')
								, 'ng-model' => 'forgot.record.reset_code'
								, 'autocomplete' => 'off'
							)
						) !!}
					</div>
					
					<div class="btn-container">
						{!! Form::button( trans('messages.client_proceed')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'forgot.validateCode($event)'
							)
						) !!}

						{!! Form::button('trans(messages.client_resend_code)'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => 'forgot.resendCode()'
							)
						) !!}
					</div>

					<br />
					<a href="{!! route('admin.login') !!}"><i class="fa fa-home"></i> {!! trans('messages.forgot_home') !!}</a>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	{!! Html::script('/js/admin/controllers/login_controller.js') !!}
	{!! Html::script('/js/admin/services/login_service.js') !!}
@stop
