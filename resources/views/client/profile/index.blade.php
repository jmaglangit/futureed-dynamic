@extends('client.app')

@section('navbar')
    @include('client.partials.main-nav')
@stop
@section('content')
	<div class="container dshbrd-con" ng-controller="ProfileController as profile" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')				
			</div>
			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content" ng-if="!profile.edit">
						<span ng-if="profile.active_index">My Profile</span>
						<span ng-if="profile.active_edit">Edit Profile</span>
						<span ng-if="profile.active_password">Change Password</span>
					</div>
				</div>
				<div class="form-content col-xs-12">
					<div class="alert alert-error" ng-if="profile.errors">
			            <p ng-repeat="error in profile.errors track by $index" > 
			              	{! error !}
			            </p>
			        </div>
	                <div class="alert alert-success" ng-if="profile.success">
	                	<p>Successfully update profile.</p>
	                </div>
	                <div index-form template-url="{!! route('client.profile.index_form') !!}"></div>

	                <div change-password-form template-url="{!! route('client.profile.change_password_form') !!}"></div>
				</div>
			</div>
		</div>		
	</div>
@stop

@section('footer')

@section('scripts')
	
	{!! Html::script('/js/client/controllers/profile_controller.js') !!}
	{!! Html::script('/js/client/services/profile_service.js') !!}

@stop