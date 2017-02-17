@extends('student.app')

@section('content')
	<div class="container login student-fnt" ng-controller="StudentPasswordController as password" 
		ng-init="password.checkForgotPasswordLink('{!! $email !!}')" ng-cloak>

		<div template-directive template-url="{!! route('student.partials.base_url') !!}"></div>

		<div template-directive template-url="{!! route('student.login.password.enter_reset_code') !!}"></div>

		<div class="login-container" ng-if="password.active_default">
			<div class="form-style" ng-show="!password.sent">
				<div class="title">{!! trans('messages.retrieve_pic_password') !!}</div>

				<div class="alert alert-danger" ng-if="password.errors">
					<p ng-repeat="error in password.errors" > 
						{! error !}
					</p>
				</div>				

				{!! Form::open(array('ng-submit' => 'password.sendResetCode($event)')) !!}
					<div class="input">
						<div class="icon">
							<i class="fa fa-user"></i>
						</div>
						{!! Form::text('username', ''
							, array(
								'class' => 'form-control'
								, 'placeholder' => trans('messages.username_or_email')
								, 'autocomplete' => 'off'
								, 'ng-model' => 'password.record.username'
							)
						) !!}
					</div>
					<div class="btn-container">
						{!! Form::button(trans('messages.forgot_send')
							, array(
								  'class' => 'btn btn-green btn-medium'
								, 'ng-click' => 'password.sendResetCode($event)'
							)
						) !!}

						{!! Html::link(route('student.login'), trans('messages.cancel')
							, array(
								'class' => 'btn btn-gray btn-medium',
								'style' => 'margin-right: 0;'
							)
						) !!}
					</div>
				{!! Form::close() !!}
			</div>

			<div class="form-style" ng-if="password.sent">
			{!! Form::open(array('id' => 'redirect_form', 'method' => 'POST', 'route' => 'student.login.reset_password')) !!}
				{!! Form::hidden('id') !!}
				{!! Form::hidden('reset_code', '') !!}
			{!! Form::close() !!}

				<div class="form_content">
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
							{!! trans('messages.an_email_reset_pic_password') !!}
						</p>
					</div>

					<div ng-if="password.resent">
						<div class="roundcon">
							<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
						</div>

						<p class="text">
							<br /> {!! trans('messages.a_new_email_reset_pic_password') !!}
						</p>
					</div>

					<div class="form-group">
						<small>{!! trans('messages.client_check_inbox') !!}</small>
					</div>

					{!! Form::open(array('ng-submit' => 'password.validateCode($event)')) !!}
						<div class="form-group">
							{!! Form::text('reset_code', ''
								, array(
									'class' => 'form-control'
									, 'placeholder' => trans('messages.client_reset_code')
									, 'autocomplete' => 'off'
									, 'ng-disabled' => 'password.password_set'
									, 'ng-model' => 'password.record.reset_code'
								)
							) !!}
						</div>
						<div class="btn-container">
							{!! Form::button(trans('messages.client_proceed')
									, array(
											  'class' => 'btn btn-maroon btn-medium'
											, 'ng-if' => '!password.password_set'
											, 'ng-click' => 'password.validateCode($event)'
									)
							) !!}

							{!! Form::button(trans('messages.client_resend_code')
									, array(
											'class' => 'btn btn-gold btn-medium'
											, 'ng-if' => '!password.password_set'
											, 'ng-click' => 'password.resendResetCode()'
											, 'style' => 'margin-right: 0;'
									)
							) !!}
						</div>
						
						<br />
						<a href="{!! route('student.login') !!}"><i class="fa fa-home"></i> {!! trans('messages.forgot_home') !!}</a>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	{!! Html::script('/js/student/controllers/student_password_controller.js') !!}
    {!! Html::script('/js/student/services/student_password_service.js') !!}
@stop