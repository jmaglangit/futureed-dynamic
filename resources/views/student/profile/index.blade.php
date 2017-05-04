@extends('student.app')

@section('styles')
	{!! Html::style('/css/magnific-popup.css') !!}
@stop

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
<div class="container dshbrd-con" ng-controller="ProfileController as profile" ng-init="profile.updateBackground();" ng-cloak>

  	<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

	<div template-directive template-url="{!! route('student.partials.play-game-messages') !!}"></div>

	<div class="wrapr" ng-init="profile.studentDetails();">
		<div class="hdr">
			<div class="avtrcon">
				<img ng-src="{! user.avatar !}">
			</div>
			<div class="detcon">
				<div class="rwrdscon">
					<h3>
						<div class="rbn-left"></div>
						<div class="rbn-right"></div>
						{!! trans('messages.quick') !!} <span>{!! trans('messages.rewards') !!}</span>
					</h3>
					<div class="points">
						{!! Html::image('/images/icons/icon-reward.png', ''
                            , array(
                                'class' => 'nav-icon-holder'
                            )
                        ) !!}
						<div class="pcon">
							<span>{! (user.cash_points) !}</span> {!! trans('messages.points') !!}
						</div>
						<a href="javascript:;" ng-click="profile.setStudentProfileActive('rewards')" class="lnk">{!! trans('messages.see_all_points') !!}</a>
					</div>
				</div>
				<h2 class="student-font">
					<span class="thin" ng-if="profile.active_index">{!! trans('messages.my_profile') !!}</span>
					<span class="thin" ng-if="profile.active_edit">{!! trans('messages.edit_profile') !!}</span>
					<span class="thin" ng-if="profile.active_edit_email">{!! trans('messages.admin_edit_email') !!}</span>
					<span class="thin" ng-if="profile.active_confirm_email">{!! trans('messages.confirm_email') !!}</span>
					<span class="thin" ng-if="profile.active_rewards">{!! trans('messages.my_rewards') !!}</span>
					<span class="thin" ng-if="profile.active_avatar">{!! trans('messages.change_avatar') !!}</span>
					<span class="thin" ng-if="profile.active_avatar_accessory">{!! trans('messages.avatar_accessories') !!}</span>
					<div ng-if="profile.active_password">
								<span ng-if="!profile.password_validated" class="thin">
									{!! trans('messages.current') !!}
								</span>
								<span ng-if="profile.password_validated && !profile.password_selected" class="thin">
									{!! trans('messages.new') !!}
								</span>
								<span ng-if="profile.password_validated && profile.password_selected && !profile.password_confirmed" class="thin">
									{!! trans('messages.confirm') !!}
								</span>

						{!! trans('messages.picture_password') !!}

						<span ng-if="profile.password_validated && profile.password_selected && profile.password_confirmed" class="thin">
									{!! trans('messages.successfully_changed') !!}
								</span>
					</div>

				</h2>
			</div>
		</div>
		<div class="side-nav">
			@include('student.partials.dshbrd-side-nav')
		</div>
		<div class="content">
			<div class="form-content col-xs-12">
				<div class="alert alert-error" ng-if="profile.errors">
		            <p ng-repeat="error in profile.errors" > 
		              {! error !}
		            </p>
		        </div>
                
				<div template-directive template-url="{!! route('student.partials.profile_form') !!}"></div>

				<div template-directive template-url="{!! route('student.partials.edit_email_form') !!}"></div>

				<div template-directive template-url="{!! route('student.partials.confirm_email_form') !!}"></div>

				<div template-directive template-url="{!! route('student.partials.rewards_form') !!}"></div>

				<div template-directive template-url="{!! route('student.partials.avatar_form') !!}"></div>

				<div template-directive template-url="{!! route('student.partials.change_password_form') !!}"></div>

				<div template-directive template-url="{!! route('student.partials.avatar_accessory_form') !!}"></div>

				<div template-directive template-url="{!! route('student.partials.settings') !!}"></div>

				<div template-directive template-url="{!! route('student.partials.games_list') !!}"></div>

				<div template-directive template-url="{!! route('student.partials.play-game') !!}"></div>

			</div>
		</div>
	</div>

	
</div>
@stop

@section('scripts')
	{!! Html::script('/js/jquery.magnific-popup.js') !!}
	{!! Html::script('/js/student/controllers/profile_controller.js') !!}
	{!! Html::script('/js/student/services/profile_service.js') !!}

	{!! Html::script('/js/student/controllers/student_reports_controller.js') !!}
	{!! Html::script('/js/student/services/student_reports_service.js') !!}

	{!! Html::script('/js/common/table_service.js') !!}
	{!! Html::script('/js/common/search_service.js') !!}

	{!! Html::script('/js/student/profile.js') !!}
@stop