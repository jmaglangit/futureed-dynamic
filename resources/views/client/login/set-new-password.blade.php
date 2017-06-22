@extends('client.app')

@section('content')
<div class="container login" ng-controller="ClientPasswordController as password" 
	ng-init="password.setPasswordStatus('{!! $id !!}')" ng-cloak>
		
		<div class="client-container form-style" ng-if="!password.success">
				<div class="title">{!! trans('messages.set_new_password') !!}</div>

					<div class="alert alert-danger" ng-if="password.errors">
						<p ng-repeat="error in password.errors" > 
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
											'ng-model' => 'password.record.new_password'
										, 'placeholder' => trans('messages.new_password')
									)
						) !!}
					</div>
					<div class="input">
						<div class="icon">
							<i class="fa fa-lock"></i>
						</div>
						{!! Form::password('confirm_password'
									, array(
											'ng-model' => 'password.record.confirm_password'
										, 'placeholder' => trans('messages.confirm_new_password')
									)
						) !!}
					</div>

					<div class="btn-container">
						{!! Form::button(trans('messages.set_password')
								, array(
									'class' => 'btn btn-blue btn-large'
									, 'ng-click' => 'password.setNewClientPassword()'
								)
						) !!}
				 </div>
				{!! Form::close() !!}
		</div>

		<div class="client-container form-style" ng-if="password.success">
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
@endsection

@section('scripts')
	{!! Html::script('/js/client/controllers/client_password_controller.js') !!}
	{!! Html::script('/js/client/services/client_password_service.js') !!}
@stop
