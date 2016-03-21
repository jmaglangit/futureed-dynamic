@extends('student.app')

@section('content')
<div class="container login" ng-init="resetChecked()" ng-cloak>
	<div class="form-style form-wide">
		{!! Form::open(array('id' => 'process_form', 'method' => 'GET', 'route' => 'student.dashboard.index')) !!}
			{!! Form::hidden('user_data', '') !!}
		{!! Form::close() !!}

		<form class="form-horizontal" name="followup_registration_form">
			<div class="form-header">
				<div class="lmtcontain">                    
				</div>
			</div>
			<div class="">
				<div ng-if="!has_avatar">
					<div class="lmtcontain form-select-password form-group">
						<h4>{!! trans('messages.pick_an_avatar') !!}</h4>
						<div class="alert alert-danger" ng-if="errors">
							<p ng-repeat="error in errors" > 
							  {! error !}
							</p>
						</div>
						<div ng-if="!has_avatar">
						  <form id="change_avatar_form">
							<div class="form-select-password">
							  <div id="title" class="title"></div>
							  <div class="form_content col-xs-12">
								<ul class="avatar_list list-unstyled list-inline" ng-init="getAvatarImages()">
								  <li class="item col-xs-4" ng-repeat="avatar in avatars" ng-click="highlightAvatar($event)">
									 <img ng-src="{! avatar.url !}" alt="{! avatar.name !}">
									 <input type="hidden" id="avatar_id" name="avatar_id" value="{! avatar.id !}">
								  </li>
								</ul>
							  </div>
							</div>
						  </form>
						</div>
					</div>
					<div class="btmcon">
						<button type="button" ng-if="enable" class="btn btn-maroon btn-medium" ng-click="$parent.selectAvatar()">{!! trans('messages.client_proceed') !!}</button>
					</div>
				</div>                
			</div>
		</form>
	</div>
</div>
@stop

@section('scripts')
    {!! Html::script('/js/student/helpers/test.js')!!}
    {!! Html::script('/js/student/controllers/learning_style_controller.js')!!}
    {!! Html::script('/js/student/services/learning_style_service.js')!!}
@stop