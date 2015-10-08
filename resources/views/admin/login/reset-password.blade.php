@extends('admin.app')

@section('content')
	<div class="container login" ng-controller="AdminLoginController as forgot" 
		ng-init="forgot.initPasswordStatus('{!! $id !!}', '{!! $reset_code !!}')" ng-cloak>
		<div class="login-container form-style">
			<div ng-if="!forgot.success">
				<div class="logo-container">
					{!! Html::image('images/logo-md.png') !!}
				</div>

				<br />
				<div class="alert alert-danger" ng-if="forgot.errors">
					<p ng-repeat="error in forgot.errors">
						{! error !}
					</p>
				</div>

				<div class="adlogin-title">Reset Password</div>

				{!! Form::open(array('id' => 'login_form')) !!}
					<div class="input">
						<div class="icon">
							<i class="fa fa-unlock-alt"></i>
						</div>
						{!! Form::password('new_password'
								, array(
										'placeholder' => 'Enter Password'
										, 'ng-model' => 'forgot.new_password'
										, 'autocomplete' => 'off'
								)
						) !!}
					</div>

					<div class="input pass">
						<div class="icon">
							<i class="fa fa-lock"></i>
						</div>
						{!! Form::password('confirm_password'
								, array(
										'placeholder' => 'Confirm Password'
										, 'ng-model' => 'forgot.confirm_password'
								)
						) !!}
					</div>

					{!! Form::button('Reset'
						, array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'forgot.resetPassword()'
						)
					) !!}
				{!! Form::close() !!}
			</div>

			<div ng-if="forgot.success">
				<div class="logo-container">
					{!! Html::image('images/logo-md.png') !!}
				</div>

				<br />
				<div class="adlogin-title">Reset Password Success</div>

				<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
				</div>

				<div class="forgot-message">
					<strong>Success!</strong>
					<p>Your password has been set.</p>
					<p> You may now use your new password to login.</p>
				</div>

				<br />

				<div class="btn-container">
					<a class="btn btn-blue btn-large" href="{!! route('admin.login') !!}">Click here to Login</a>
				</div>
			</div>
		</div>
	</div>
	@endsection

@section('scripts')
	{!! Html::script('/js/admin/controllers/login_controller.js') !!}
	{!! Html::script('/js/admin/services/login_service.js') !!}
@stop