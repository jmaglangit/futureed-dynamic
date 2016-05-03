@extends('admin.app')

@section('content')
	<div class="container login" ng-controller="AdminLoginController as login" ng-cloak>
		<div class="login-container">
			<div class="form-style form-narrow">
				<div class="logo-container">
					{!! Html::image('images/logo-md-beta.png') !!}
				</div>
				<br />
				<div class="alert alert-danger" ng-if="login.errors">
					<p ng-repeat="error in login.errors">
						{! error !}
					</p>
				</div>
					{!! Form::open(
						array(
							'id' => 'login_form'
							, 'route' => 'admin.login.process'
							, 'method' => 'POST'
						)
					) !!}
					<div class="input">
						<div class="icon">
							<i class="fa fa-user"></i>
						</div>
						{!! Form::text('login', ''
								, array(
										'placeholder' => 'Email or Username'
										, 'ng-model' => 'login.username'
										, 'autocomplete' => 'off'
								)
						) !!}
					</div>
					<div class="input pass">
						<div class="icon">
							<i class="fa fa-lock"></i>
						</div>
						{!! Form::password('password'
								, array(
										'placeholder' => 'Password'
										, 'ng-model' => 'login.password'
								)
						) !!}
					</div>

					{!! Form::hidden('user_data', ''
							, array(
								 'ng-model' => 'user_data',
								 'id' => 'user_data'
							)
					) !!}

					{!! Form::button(trans('messages.login')
							, array(
									'class' => 'btn btn-blue'
									, 'ng-click' => 'login.validateAdmin()'
							)
					) !!}

					{!! Form::close() !!}
					<br />
					<div class="form-group">
						<a href="{!! route('admin.login.forgot_password') !!}" style="color:#055A7F;">{!! trans('messages.login_forgot') !!}</a>
					</div>
			</div>
			<div class="col-xs-12" style="padding-top: 10px;padding-bottom: 10px; background-color: #A92147;">
				<center>
					{!! Html::link(url('/lang/en'), 'English - US, '
                          , array(
                              'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px',
                          )
                      ) !!}

					{!! Html::link(url('/lang/id'), 'Bahasa Indonesia, '
                            , array(
                                'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px',
                            )
                        ) !!}

					{!! Html::link(url('/lang/th'), 'Thai '
                            , array(
                                'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px',
                            )
                        ) !!}
				</center>
			</div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/login_controller.js')!!}
	{!! Html::script('/js/admin/services/login_service.js')!!}
@stop