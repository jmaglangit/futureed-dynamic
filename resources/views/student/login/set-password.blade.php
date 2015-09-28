@extends('student.app')

@section('content')
	<div class="container login" ng-controller="StudentLoginController as login" 
		ng-init="login.setPasswordStatus('{!! $id !!}')" ng-cloak>

		{!! Form::open(array('id' => 'set_password_form'))!!}
			<div class="form-style login-container form-select-password" ng-if="!login.password_isset">
				<div  id="title" class="title">
					<p ng-if="!login.password_selected">Select a picture for your new picture password</p>
					<p ng-if="login.password_selected">Select a picture to confirm your new picture password</p>
				</div>

				<div class="alert alert-danger" ng-if="login.errors">
					<p ng-repeat="error in login.errors" > 
						{! error !}
					</p>
				</div>

				<div class="form_content">
					<ul class="form_password list-unstyled list-inline" ng-init="getImagePassword()">
						<li class="item col-xs-4" ng-repeat="item in image_pass" ng-click="highlight($event)">
							<img ng-src="{! item.url !}" alt="{! item.name !}">
							<input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
						</li>
					</ul>

					{!! Form::button('Proceed'
						, array(
							'class' => 'btn btn-maroon btn-medium'
							, 'ng-click' => 'login.selectNewPassword()'
							, 'ng-if' => '!login.password_selected'
						) 
					) !!}

					<div ng-if="login.password_selected">
						<div class="btn-container">
							{!! Form::button('Previous'
								, array(
									'class' => 'btn btn-maroon btn-medium'
									, 'ng-click' => 'login.undoNewPassword()'
								) 
							) !!}

							{!! Form::button('Save'
								, array(
									'class' => 'btn btn-gold btn-medium'
									, 'ng-click' => 'login.saveNewPassword()'
								) 
							) !!}
						</div>  
					</div>
				</div>
			</div>

			{!! Form::hidden('id', $id, array('ng-model' => 'id')) !!}

		{!! Form::close() !!}

		<div class="form-style login-container form-select-password" ng-if="login.password_isset">
			<div class="title">Success!</div>

			<div class="roundcon">
				<i class="fa fa-check fa-5x img-rounded text-center"></i>
			</div>

			Your picture password has been set. <br /> 
			You may now use your new picture password to login. <br />

			<br />

			{!! Html::link(route('student.login') , 'Click here to Login'
				, array(
					'class' => 'btn btn-maroon'
				)
			) !!}
		</div>
	</div>
@endsection

@section('scripts')
	{!! Html::script('//connect.facebook.net/en_US/sdk.js') !!}
	{!! Html::script('https://apis.google.com/js/platform.js') !!}
	{!! Html::script('https://apis.google.com/js/client.js') !!}

	{!! Html::script('/js/common/validation_service.js') !!}

	{!! Html::script('/js/student/controllers/media_login_controller.js') !!}
	{!! Html::script('/js/student/services/media_login_service.js') !!} 

	{!! Html::script('/js/student/controllers/login_controller.js') !!}
	{!! Html::script('/js/student/services/login_service.js') !!}
@stop