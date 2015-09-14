@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
<div class="container dshbrd-con" ng-controller="ProfileController as profile" ng-cloak>

  	<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

	<div class="wrapr"> 
		<div class="side-nav">
			@include('student.partials.dshbrd-side-nav')
		</div>
		<div class="content">
			<div class="hdr">
				<div class="avtrcon">
					<img ng-src="{! profile.prof.avatar !}">
				</div>
				<div class="detcon">
					<div class="rwrdscon">
						<h3>
							<div class="rbn-left"></div>
							<div class="rbn-right"></div>
							Quick <span>Rewards</span>
						</h3>
						<div class="points">
							{!! Html::image('/images/icons/icon-reward.png', ''
								, array(
									'class' => 'nav-icon-holder'
								)
							) !!}
							<div class="pcon">
								<span>{! user.points !}</span> points
							</div>
							<a href="javascript:;" ng-click="profile.setStudentProfileActive('rewards')" class="lnk">See all points</a>
						</div>
					</div>
					<h2 class="student-font">
							<span class="thin" ng-if="profile.active_index">My Profile</span>
							<span class="thin" ng-if="profile.active_edit">Edit Profile</span>
							<span class="thin" ng-if="profile.active_edit_email">Edit Email Address</span>
							<span class="thin" ng-if="profile.active_confirm_email">Confirm Email Address</span>
							<span class="thin" ng-if="profile.active_rewards">Student Rewards</span>
							<span class="thin" ng-if="profile.active_avatar">Change Avatar</span>
							<div ng-if="profile.active_password">
								<span ng-if="!profile.password_validated" class="thin">
									Current
								</span>
								<span ng-if="profile.password_validated && !profile.password_selected" class="thin">
									New
								</span>
								<span ng-if="profile.password_validated && profile.password_selected && !profile.password_confirmed" class="thin">
									Confirm
								</span>   

								Picture Password

								<span ng-if="profile.password_validated && profile.password_selected && profile.password_confirmed" class="thin">
									Successfully Changed
								</span>
							</div>
							
					</h2>
				</div>
			</div>
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
			</div>
		</div>
	</div>

	
</div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/profile_controller.js') !!}
	{!! Html::script('/js/student/services/profile_service.js') !!}
	{!! Html::script('/js/student/profile.js') !!}
@stop