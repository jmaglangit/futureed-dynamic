@extends('student.app')

	@section('navbar')
	    @include('student.partials.main-nav')
	@stop

	@section('content')
	<div class="container dshbrd-con" ng-init="getUserDetails()" ng-cloak>
		<div class="wrapr"> 
			<div class="side-nav">
				@include('student.partials.dshbrd-side-nav')
			</div>
			<div class="content">
				<div class="hdr">
					<div class="avtrcon">
						{!! Html::image('images/password/img-pass-03.jpg') !!}
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
					<div ng-if="password_validated && password_selected && password_confirmed">
						<p>Your Picture Password has been saved.</p>
						<p>You may now use this picture password in your suceeding login.</p>
					</div>
					<div class="col-md-8 col-md-offset-2" ng-if="!password_confirmed">
				      <form id="reset_password_form">
				        <div class="form-select-password">
				          <div id="title" class="title"></div>
				          <div class="error" ng-if="error">
				            <p>{! error !}</p>
				          </div>
				          <div class="form_content">
				            <ul class="form_password list-unstyled list-inline">
				              <li class="item" ng-repeat="item in image_pass" ng-click="highlight($event)">
				                 <img ng-src="{! item.url !}" alt="{! item.name !}">
				                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
				              </li>
				            </ul>
							<button ng-if="!password_validated" type="button" class="btn btn-red" ng-click="validateCurrentPassword()">Proceed</button>
							<button ng-if="password_validated && !password_selected" type="button" class="btn btn-red" ng-click="selectNewPassword()">Proceed</button>
							<div class="row" ng-if="password_validated && password_selected && !password_confirmed">
					          	<div class="col-sm-6"><button type="button" ng-click="undoNewPassword()" class="btn btn-red">Previous</button></div>
					          	<div class="col-sm-6"><button type="button" class="btn btn-red" ng-click="confirmNewPassword()">Change</button></div>
					        </div>
							</div>

				          <input type="hidden" name="selected_image_id" id="selected_image_id" />
				          <input type="hidden" name="image_pass" />
				        </div>
				      </form>
				    </div>
				  </div>
				</div>
			</div>
		</div>

		<textarea id="userdata" name="hide" style="display:none;">{!! Session::get('user') !!}</textarea>
	</div>
	@stop

	@section('footer')

	@overwrite

	@section('scripts')

	@stop