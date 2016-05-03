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

				<div class="adlogin-title">{!! trans('messages.reset_password') !!}</div>

				{!! Form::open(array('id' => 'login_form')) !!}
					<div class="input">
						<div class="icon">
							<i class="fa fa-unlock-alt"></i>
						</div>						
						{!! Form::password('new_password'
								, array(
										'placeholder' => trans('messages.enter_password')
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
										'placeholder' => trans('messages.confirm_password')
										, 'ng-model' => 'forgot.confirm_password'
								)
						) !!}
					</div>

					{!! Form::button( trans('messages.reset')
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
				<div class="adlogin-title">{!! trans('messages.reset_password_success') !!}</div>

				<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
				</div>

				<div class="forgot-message">
					<strong>{!! trans('messages.success') !!}</strong>
					<p>{!! trans('messages.password_set') !!}</p>
					<p>{!! trans('messages.password_new_use') !!}</p>
				</div>

				<br />

				<div class="btn-container">
					<a class="btn btn-blue btn-large" href="{!! route('admin.login') !!}">{!! trans('messages.click_to_login') !!}</a>
				</div>
			</div>
		</div>
	</div>
	@endsection

@section('scripts')
	{!! Html::script('/js/admin/controllers/login_controller.js') !!}
	{!! Html::script('/js/admin/services/login_service.js') !!}
@stop