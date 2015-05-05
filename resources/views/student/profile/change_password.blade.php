@extends('student.app')

	@section('navbar')
	    @include('student.partials.main-nav')
	@stop

	@section('content')
	<div class="container dshbrd-con" ng-cloak>
		<div class="wrapr"> 
			<div class="side-nav">
				@include('student.partials.dshbrd-side-nav')
			</div>
			<div class="content">
				<div class="hdr">
					<div class="avtrcon">
						<img ng-src="{! user.avatar !}">
					</div>
					<div class="detcon">
						<h2>
							<span ng-if="!password_validated" class="thin">Current</span> 
							<span ng-if="password_validated && !password_selected" class="thin">New</span> 
							<span ng-if="password_validated && password_selected && !password_confirmed" class="thin">Confirm</span> 
						Password <span ng-if="password_validated && password_selected && password_confirmed" class="thin">Successfully Changed</span> </h2>
						<hr />
						<p ng-if="!password_validated">
							Select your current picture password
						</p>
						<p ng-if="password_validated && !password_selected">
							Select your new picture password
						</p>
						<p ng-if="password_validated && password_selected && !password_confirmed">
							Confirm your new picture password
						</p>
					</div>
				</div>
				<div class="form-content col-md-12">
					<div class="alert alert-success" ng-if="password_validated && password_selected && password_confirmed">
						<p>Your Picture Password has been saved.</p>
						<p>You may now use this picture password in your suceeding login.</p>
					</div>
					<div class="col-md-8 col-md-offset-2" ng-if="locked">
						<div class="form-style" style="box-shadow: none;">
							@include('student.login.account-locked')
						</div>
					</div>

					<div class="col-md-8 col-md-offset-2" ng-if="!password_confirmed && !locked">
				      {!! Form::open(array('id' => 'change_password_form')) !!}
				        <div class="form-select-password">
				          <div class="alert alert-danger" ng-if="errors">
				            <p ng-repeat="error in errors" > 
				              {! error !}
				            </p>
				          </div>
				          <div class="form_content">
				            <ul class="form_password list-unstyled list-inline">
				              <li class="item" ng-repeat="item in image_pass" ng-click="highlight($event)">
				                 <img ng-src="{! item.url !}" alt="{! item.name !}">
				                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
				              </li>
				            </ul>
						  </div>
				        </div>
				      {!! Form::close() !!}
				    </div>

				    <div class="btn-container">
					    <a ng-if="!password_validated" type="button" class="btn btn-maroon btn-medium" ng-click="validateCurrentPassword()">Proceed</a>
						<a ng-if="password_validated && !password_selected" type="button" class="btn btn-maroon btn-medium" ng-click="selectNewPassword()">Proceed</a>
						<a ng-if="!password_selected" href="{!! route('student.profile.index') !!}" class="btn btn-gold btn-medium">Cancel</a>

						<a ng-if="password_validated && password_selected && !password_confirmed" type="button" ng-click="undoNewPassword()" class="btn btn-maroon btn-medium">Previous</a>
						<a ng-if="password_validated && password_selected && !password_confirmed" type="button" class="btn btn-gold btn-medium" ng-click="changePassword()">Change</a>    	
				    </div>
				</div>
			</div>
		</div>
	</div>
	@stop

	@section('footer')

	@overwrite

	@section('scripts')

	@stop