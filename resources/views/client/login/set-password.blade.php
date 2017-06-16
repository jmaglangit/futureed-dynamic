@extends('client.app')

@section('content')
	<div class="container login" ng-cloak>
			<div class="client-container form-style" ng-controller="LoginController as confirm"
				ng-init="confirm.setRegistrationStatus('{!! $email !!}', '{{ $code }}')">

				{!! Form::open(array('id' => 'redirect_form', 'route' => 'client.login.set_password', 'method' => 'POST')) !!}
					{!! Form::hidden('id', '') !!}
				{!! Form::close() !!}

				<div ng-if="!confirm.confirmed">
					<div class="title">{!! trans('messages.client_thank_you_for_register') !!}</div>
			
					<div class="alert alert-danger" ng-if="confirm.errors">
						<p ng-repeat="error in confirm.errors" > 
							{! error !}
						</p>
					</div>
							
					<div class="form_content">
						<div ng-if="!confirm.resent">
							<div class="roundcon">
									<i class="fa fa-check fa-5x img-rounded text-center" ></i>
							</div>

							<p class="text">
									{!! trans('messages.client_confirmation_sent') !!}
							</p>
						</div>

						<div ng-if="confirm.resent">
							<div class="roundcon">
									<i class="fa fa-refresh fa-5x img-rounded text-center"></i>
							</div>
							
							<p class="text">
									{!! trans('messages.client_new_confirmation_code') !!}
							</p>
						</div>
							
							<br />
							<small>{!! trans('messages.client_check_inbox') !!}</small>
					</div>
				</div>

				<div ng-if="confirm.confirmed">
						<div class="title">{!! trans('messages.success') !!}</div>

						<div class="roundcon">
							<i class="fa fa-check fa-5x img-rounded text-center"></i>
						</div>

						<p>{!! trans('messages.client_registration_success_msg') !!}</p>

						<br />
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
@stop
