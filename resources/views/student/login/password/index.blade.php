@extends('student.app')

@section('content')
	<div class="container login student-fnt" ng-controller="StudentPasswordController as password" 
		ng-init="password.checkForgotPasswordLink('{!! $email !!}')" ng-cloak>

		<div template-directive template-url="{!! route('student.partials.base_url') !!}"></div>

		<div template-directive template-url="{!! route('student.login.password.enter_reset_code') !!}"></div>

		<div class="login-container" ng-if="password.active_default">
			<div class="form-style" ng-show="!password.sent">
				<div class="title">Retrieve Picture Password</div>

				<div class="alert alert-danger" ng-if="password.errors">
					<p ng-repeat="error in password.errors" > 
						{! error !}
					</p>
				</div>				

				{!! Form::open(array('ng-submit' => 'password.sendResetCode($svent)')) !!}
					<div class="input">
						<div class="icon">
							<i class="fa fa-user"></i>
						</div>
						{!! Form::text('username', ''
							, array(
								'class' => 'form-control'
								, 'placeholder' => 'Username or Email'
								, 'autocomplete' => 'off'
								, 'ng-model' => 'password.record.username'
							)
						) !!}
					</div>
					<div class="btn-container">
						{!! Form::button('Send'
							, array(
								  'class' => 'btn btn-maroon btn-medium'
								, 'ng-click' => 'password.sendResetCode($svent)'
							)
						) !!}

						{!! Html::link(route('student.login'), 'Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
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
					<div class="title" ng-if="!password.resent">Reset Code Sent</div>
					<div class="title" ng-if="password.resent">Reset Code Resent</div>

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
							An email to reset your picture password has been sent to your email account. 
						</p>
					</div>

					<div ng-if="password.resent">
						<div class="roundcon">
							<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
						</div>

						<p class="text">
							<br /> A new email to reset your picture password has been sent to your email account. 
						</p>
					</div>

					<div class="form-group">
						<small>Please check your inbox or your spam folder for the email. 
						<br />The email contains a code that you need to input below.</small>
					</div>

					{!! Form::open(array('ng-submit' => 'password.validateCode($event)')) !!}
						<div class="form-group">
							{!! Form::text('reset_code', ''
								, array(
									'class' => 'form-control'
									, 'placeholder' => 'Reset Code'
									, 'autocomplete' => 'off'
									, 'ng-disabled' => 'password.password_set'
									, 'ng-model' => 'password.record.reset_code'
								)
							) !!}
						</div>
						<div class="btn-container">
							{!! Form::button('Proceed'
									, array(
											  'class' => 'btn btn-maroon btn-medium'
											, 'ng-if' => '!password.password_set'
											, 'ng-click' => 'password.validateCode($event)'
									)
							) !!}

							{!! Form::button('Resend Code'
									, array(
											'class' => 'btn btn-gold btn-medium'
											, 'ng-if' => '!password.password_set'
											, 'ng-click' => 'password.resendResetCode()'
									)
							) !!}
						</div>
						
						<br />
						<a href="{!! route('student.login') !!}"><i class="fa fa-home"></i> Home</a>
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