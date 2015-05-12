@extends('client.app')
	@section('navbar')
		@include('client.partials.main-nav')
	@stop

	@section('content')
		<div class="container dshbrd-con" ng-cloak>
			<div class="wrapr">
				<div class="client-nav side-nav">
					@include('client.partials.dshbrd-side-nav')
				</div>
				<div class="client-content">
					<div class="content-title">
						<div class="title-main-content">
							Change Password
						</div>
					</div>
					<div class="form-content col-xs-12">
						<div class="alert alert-error" ng-if="errors">
				            <p ng-repeat="error in errors" > 
				              {! error !}
				            </p>
				        </div>
				        <div class="alert alert-success" ng-if="success">
		                	<p>Successfully update profile.</p>
		                </div>
					</div>
				</div>
			</div>			
		</div>
	@stop

	@section('footer')

	@section('scripts')

	@stop