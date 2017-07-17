@extends('client.app')

@section('content')
<div class="container login" ng-controller="LoginController as login" 
	ng-init="login.setRegistrationStatus('{!! $email !!}','{!! $code !!}')" ng-cloak>
	
	{!! Form::open(array('id' => 'process_form', 'method' => 'POST', 'route' => 'client.login.process')) !!}
		{!! Form::hidden('user_data', '') !!}
	{!! Form::close() !!}

	<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

	<div class="client-container form-style">
		<div class="title" ng-if="login.account_confirmed || login.confirmed">{!! trans('messages.success') !!}</div>

		<div class="alert alert-danger" ng-if="login.errors">
			<p ng-repeat="error in login.errors">
				{! error !}
			</p>
		</div>

		<div ng-if="!login.confirmed">
			<div class="title">{!! trans('messages.confirm_email_address') !!}</div>

			<div class="form_content">

				<div ng-if="!login.resent">
					<div class="roundcon">
						<i class="fa fa-check fa-5x img-rounded text-center"></i>
					</div>

					<div class="roundcon" ng-if="login.errors">
						<i class="fa fa-close fa-5x img-rounded text-center"></i>
					</div>
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

		<div ng-if="login.confirmed || login.account_confirmed">
			<div class="form_content">
				<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
				</div>

				<p>{!! trans('messages.client_registration_success_msg') !!}</p>				
			</div> 
			<div class="btn-container">
				<a class="btn btn-blue btn-large" href="{!! route('client.login') !!}">{!! trans('messages.click_to_login') !!}</a>
			</div>
		</div> 
	</div>
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