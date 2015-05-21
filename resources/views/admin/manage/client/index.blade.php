@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="AdminClientController as client" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				<div template-directive template-url="{!! route('admin.manage.client.partials.side_nav') !!}"></div>
			</div>
			
			<div class="content-title">
				<div class="title-main-content">
					<span>Add New Client</span>
				</div>
			</div>

			<div class="alert alert-error" ng-if="errors">
	            <p ng-repeat="error in profile.errors track by $index" > 
	              	{! error !}
	            </p>
	        </div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.list_client_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.add_client_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.edit_email_form') !!}"></div>
			
			<!-- <div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.confirm_email_form') !!}"></div> -->
		</div>		
	</div>
@stop

@section('footer')	
	
@section('scripts')
	{!! Html::script('/js/admin/admin_client_constants.js')!!}
	{!! Html::script('/js/admin/admin_client.js')!!}
	{!! Html::script('/js/admin/controllers/datatables_controller.js')!!}
	{!! Html::script('/js/admin/controllers/admin_client_controller.js')!!}
@stop