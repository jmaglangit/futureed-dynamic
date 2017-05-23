@extends('student.app')

@section('content')
<div id="studentBackground">
	<div class="container login" ng-controller="StudentPasswordController as password" 
		ng-init="password.setPasswordStatus('{!! $id !!}')" ng-cloak>

		<div class="form-style login-container form-select-password" ng-if="!password.password_isset">
			<div id="title" class="title title-container">
				<p ng-if="!password.password_selected" class="h4 title-text">{!! trans('messages.select_pic_new_pic_password') !!}</p>
				<p ng-if="password.password_selected" class="h4 title-text">{!! trans('messages.select_pic_confirm_pic_password') !!}</p>
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

				{!! Form::button(trans('messages.client_proceed')
					, array(
						'class' => 'btn btn-green btn-medium'
						, 'ng-click' => 'password.selectNewPassword()'
						, 'ng-if' => '!password.password_selected'
					) 
				) !!}

				<div ng-if="password.password_selected">
					<div class="btn-container">
						{!! Form::button(trans('messages.previous')
							, array(
								'class' => 'btn btn-maroon btn-medium'
								, 'ng-click' => 'password.undoNewPassword()'
							) 
						) !!}

						{!! Form::button(trans('messages.save')
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
			<div class="title">{!! trans('messages.success') !!}</div>

			<div class="roundcon">
				<i class="fa fa-check fa-5x img-rounded text-center"></i>
			</div>

			{!! trans('messages.your_pic_password_set') !!} <br />
			{!! trans('messages.you_may_now_use_new_pic_password_to_login') !!} <br />

			<br />

			{!! Html::link(route('student.login') , trans('messages.click_to_login')
				, array(
					'class' => 'btn btn-green'
				)
			) !!}
		</div>
	</div>
</div>
@endsection

@section('scripts')
	{!! Html::script('/js/student/controllers/student_password_controller.js') !!}
    {!! Html::script('/js/student/services/student_password_service.js') !!}
@stop