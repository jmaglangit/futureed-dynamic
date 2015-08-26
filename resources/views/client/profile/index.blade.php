@extends('client.app')

@section('navbar')
    @include('client.partials.main-nav')
@stop
@section('content')
	<div class="container dshbrd-con" ng-controller="ProfileController as profile" ng-init="profileActive = futureed.TRUE" ng-cloak>
  		
  		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')				
			</div>
			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content" ng-if="!profile.edit">
						<span ng-if="profile.active_index">My Profile</span>
						<span ng-if="profile.active_edit">Edit Profile</span>
						<span ng-if="profile.active_edit_email">Edit Email Address</span>
						<span ng-if="profile.active_confirm_email">Confirm Email Address</span>
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
	                	<p>You have successfully updated your profile.</p>
	                </div>
	                <div template-directive template-url="{!! route('client.profile.partial.index_form') !!}"></div>

	                <div template-directive template-url="{!! route('client.profile.partial.edit_email_form') !!}"></div>

	                <div template-directive template-url="{!! route('client.profile.partial.confirm_email_form') !!}"></div>

	                <div template-directive template-url="{!! route('client.profile.partial.change_password_form') !!}"></div>
				</div>
			</div>
		</div>		
	</div>
@stop

@section('scripts')
	
	{!! Html::script('/js/client/controllers/profile_controller.js') !!}
	{!! Html::script('/js/client/services/profile_service.js') !!}
	{!! Html::script('/js/client/profile.js') !!}

@stop