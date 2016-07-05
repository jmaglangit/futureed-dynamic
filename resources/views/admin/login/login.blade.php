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

			<div class="col-xs-12" style="padding-top: 10px;padding-bottom: 10px; color: whitesmoke;">
				<center>
					<div class="dropdown col-xs-12 border-radius-3" style="background-color: #A92147;padding:5px;">
						<button class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="background-color: #A92147;">-- Choose Language --</button>
						<ul class="dropdown-menu" style="background-color: #A92147;">
							<li>
								{!! Html::link(url('/lang/ar'), 'Arabic '
                                    , array(
                                        'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                    )
                                ) !!}
							</li>

							<li>
								{!! Html::link(url('/lang/id'), 'Bahasa Indonesia '
                                        , array(
                                            'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                        )
                                    ) !!}
							</li>

							<li>
								{!! Html::link(url('/lang/ms'), 'Bahasa Malaysia '
                                        , array(
                                            'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                        )
                                    ) !!}
							</li>

							<li>
								{!! Html::link(url('/lang/my'), 'Burmese '
                                        , array(
                                            'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                        )
                                    ) !!}
							</li>

							<li>
								{!! Html::link(url('/lang/es'), 'Español '
                                        , array(
                                            'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                        )
                                    ) !!}
							</li>

							<li>
								{!! Html::link(url('/lang/en'), 'English - US '
                                      , array(
                                          'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                      )
                                  ) !!}
							</li>

							<li>
								{!! Html::link(url('/lang/pt'), 'Portuguese '
                                        , array(
                                            'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                        )
                                    ) !!}
							</li>

							<li>
								{!! Html::link(url('/lang/th'), 'Thai '
                                        , array(
                                            'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                        )
                                    ) !!}
							</li>

							<li>
								{!! Html::link(url('/lang/vi'), 'Vietnamese '
                                        , array(
                                            'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                        )
                                    ) !!}
							</li>
						</ul>
					</div>
				</center>
			</div>

		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/login_controller.js')!!}
	{!! Html::script('/js/admin/services/login_service.js')!!}
@stop