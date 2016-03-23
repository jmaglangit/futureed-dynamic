@extends('client.app')

@section('content')
	<div class="container login" ng-cloak>
			<div class="client-container form-style" ng-controller="LoginController as confirm"
				ng-init="confirm.setRegistrationStatus('{!! $email !!}')"> 
				<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
				
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
							{!! Form::open(array('ng-submit' => 'confirm.confirmClientRegistration($event)')) !!}
									<div class="form-group" ng-if="!confirm.account_confirmed">
											{!! Form::label('', 'trans('messages.enter_confirmation_code'):')!!}
											
											{!! Form::text('confirmation_code', ''
															, array(
																	'class' => 'form-control'
																	, 'placeholder' => 'trans('messages.confirm_code')'
																	, 'ng-model' => 'confirm.record.email_code'
																	, 'autocomplete' => 'off'
															)
											) !!}

											{!! Form::hidden('email', $email) !!}
									</div>
									<div class="btn-container">
											{!! Form::button('trans('messages.confirm')'
													, array(
																'id' => 'proceed_btn'
															, 'class' => 'btn btn-blue btn-medium'
															, 'ng-click' => 'confirm.confirmClientRegistration($event)'
															, 'ng-if' => '!confirm.account_confirmed'
													)
											) !!}

											{!! Form::button('trans('messages.resend'
													, array(
																'class' => 'btn btn-gold btn-medium'
															, 'ng-click' => 'confirm.resendClientConfirmation()'
															, 'ng-if' => '!confirm.account_confirmed'
													)
											)!!}
									</div>
									<br />
									<a href="{!! route('client.login') !!}"><i class="fa fa-home"></i> {!! trans('messages.forgot_home') !!}</a>
							{!! Form::close() !!}
					</div>
				</div>

				<div ng-if="confirm.confirmed && !confirm.success">
						<div class="title">{!! trans('messages.set_new_password') !!}</div>

							<div class="alert alert-danger" ng-if="confirm.errors">
								<p ng-repeat="error in confirm.errors" > 
									{! error !}
								</p>
							</div>
							{!! Form::open(
									array(
											'id' => 'reset_password_form'
									)
							) !!}

							<div class="input">
								<div class="icon">
									<i class="fa fa-unlock-alt"></i>
								</div>
								{!! Form::password('new_password'
											, array(
													'ng-model' => 'confirm.record.new_password'
												, 'placeholder' => 'trans('messages.new_password')'
											)
								) !!}
							</div>
							<div class="input">
								<div class="icon">
									<i class="fa fa-lock"></i>
								</div>
								{!! Form::password('confirm_password'
											, array(
													'ng-model' => 'confirm.record.confirm_password'
												, 'placeholder' => 'trans('messages.confirm_new_password')'
											)
								) !!}
							</div>

							<div class="btn-container">
								{!! Form::button('trans('messages.set_password')'
										, array(
											'class' => 'btn btn-blue btn-large'
											, 'ng-click' => 'confirm.setNewClientPassword()'
										)
								) !!}
						 </div>
						{!! Form::close() !!}
				</div>

				<div ng-if="confirm.confirmed && confirm.success">
						<div class="title">{!! trans('messages.success') !!}</div>

						<div class="roundcon">
							<i class="fa fa-check fa-5x img-rounded text-center"></i>
						</div>

						<p>{!! trans('messages.password_set') !!}</p>
						<p>{!! trans('messages.password_new_use') !!}</p>

						<br />

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
@stop