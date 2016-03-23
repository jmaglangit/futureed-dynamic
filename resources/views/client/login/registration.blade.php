@extends('client.app')

@section('content')
	<div class="container" ng-controller="LoginController as login" 
		ng-init="login.setActive('registration')" ng-cloak>

		<div ng-init="login.initMediaIds('{!! env('FB_APP_ID') !!}', '{!! env('GL_CLIENT_ID') !!}')"></div>

		{!! Form::open(array('id' => 'process_form', 'method' => 'POST', 'route' => 'client.login.process')) !!}
			{!! Form::hidden('user_data', '') !!}
		{!! Form::close() !!}

		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div template-directive template-url="{!! route('client.login.confirm_media') !!}"></div>

		<div template-directive template-url="{!! route('client.partials.registration_success') !!}"></div>
		<div template-directive template-url="{!! route('client.partials.resend_confirmation') !!}"></div>

		<div class="form-style registration-container form-wide" ng-if="login.active_registration"> 
			<div class="title col-xs-8">{!! trans('messages.client_register_as') !!}</div>
		
			<div class="row">
				<div class="col-xs-12">
					<div class="col-xs-1"></div>
					<div class="col-xs-3" ng-click="login.selectRole('Principal')">
						{!! Html::image('/images/user_principal.png', 'Principal'
							, array(
								'id' => 'user_principal'
								, 'class' => 'client-reg-img'
								, 'ng-class' => '{ role : !login.principal }'
							)
						) !!}
						<h4>{!! trans('messages.principal') !!}</h4>
					</div>
				
					<div class="col-xs-3" ng-click="login.selectRole('Parent')">
						{!! Html::image('/images/user_parent.png', 'Parent'
							, array(
								'id' => 'user_parent'
								, 'class' => 'client-reg-img'
								, 'ng-class' => '{ role : !login.parent }'
							)
						) !!}
						<h4>{!! trans('messages.parent') !!}</h4>
					</div>
					<div class="col-xs-1"></div>
					<div class="col-xs-3">
						<div class="form-group col-xs-12">
							<button type="button" class="btn btn-fb"
								ng-click="login.loginViaFacebook()">
									<i class="fa fa-facebook"></i> {!! trans('messages.client_sign_up_fb') !!}
							</button>
						</div>

						<div class="form-group col-xs-12 login-divider">
							<em>or</em>
						</div>

						<div class="form-group col-xs-12">
							<button id="btn-google" type="button" class="btn btn-google" ng-init="login.googleInit()"> 
								<span><img src="/images/icons/google-logo.png" /></span>
								<span>{!! trans('messages.client_sign_up_google') !!}</span> 
							</button>
						</div>
					</div>
				</div>
				
				 <div class="form-group col-xs-12">
					<span>{!! trans('messages.did_not_receive_email_confirmation') !!} <a class="cursor-pointer" ng-click="login.setActive('resend')">{!! trans('messages.resend_confirmation') !!}</a></span>
				</div>
			
				<div class="col-xs-12" ng-if="login.record.client_role">
					<div class="alert alert-error" ng-if="login.errors">
						<p ng-repeat="error in login.errors track by $index"> 
							{! error !}
						</p>
					</div>

					<div template-directive template-url="{!! route('client.partials.registration_form') !!}"></div>
				</div>
			</div>
		</div>

	@include('client.login.terms-and-conditions')
	
	@include('student.login.privacy-policy')

	</div>
@endsection

@section('scripts')
	{!! Html::script('//connect.facebook.net/en_US/sdk.js') !!}
	{!! Html::script('https://apis.google.com/js/platform.js') !!}
	{!! Html::script('https://apis.google.com/js/client.js') !!}

	{!! Html::script('/js/common/validation_service.js')!!}

	{!! Html::script('/js/student/controllers/media_login_controller.js') !!}
	{!! Html::script('/js/student/services/media_login_service.js') !!}

	{!! Html::script('/js/client/controllers/login_controller.js') !!}
	{!! Html::script('/js/client/services/login_service.js') !!}
	{!! Html::script('/js/client/services/profile_service.js') !!}
	{!! Html::script('/js/client/login.js') !!}

@stop