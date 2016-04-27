@extends('student.app')

@section('content')
	<div class="container login" ng-controller="StudentPasswordController as password" 
		ng-init="password.setPasswordStatus('{!! $id !!}')" ng-cloak>

		<div class="form-style login-container form-select-password" ng-if="!password.password_isset">
			<div  id="title" class="title">
				<p ng-if="!password.password_selected">Select a picture for your new picture password</p>
				<p ng-if="password.password_selected">Select a picture to confirm your new picture password</p>
			</div>

			<div class="alert alert-danger" ng-if="password.errors">
				<p ng-repeat="error in password.errors" > 
					{! error !}
				</p>
			</div>

			<div class="form_content">
				<ul class="form_password list-unstyled list-inline on-login" ng-init="getImagePassword()">
					<li class="item col-xs-4" ng-repeat="item in image_pass" ng-click="highlight($event)">
						<img ng-src="{! item.url !}" alt="{! item.name !}">
						<input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
					</li>
				</ul>

				{!! Form::button('Proceed'
					, array(
						'class' => 'btn btn-maroon btn-medium'
						, 'ng-click' => 'password.selectNewPassword()'
						, 'ng-if' => '!password.password_selected'
					) 
				) !!}

				<div ng-if="password.password_selected">
					<div class="btn-container">
						{!! Form::button('Previous'
							, array(
								'class' => 'btn btn-maroon btn-medium'
								, 'ng-click' => 'password.undoNewPassword()'
							) 
						) !!}

						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => 'password.saveNewPassword()'
							) 
						) !!}
					</div>  
				</div>
			</div>
		</div>

		<div class="form-style login-container form-select-password" ng-if="password.password_isset">
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
	{!! Html::script('/js/student/controllers/student_password_controller.js') !!}
    {!! Html::script('/js/student/services/student_password_service.js') !!}
@stop