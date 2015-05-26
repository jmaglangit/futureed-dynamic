@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageAdminController as admin" ng-cloak>
  		
  		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				<div template-directive template-url="{!! route('admin.manage.admin.partials.side_nav') !!}"></div>
			</div>	        

			<div class="client-content" template-directive template-url="{!! route('admin.manage.admin.partials.list_admin_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.admin.partials.add_admin') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.admin.partials.view_admin') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.admin.partials.reset_pass') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.admin.partials.edit_email_form') !!}"></div>
		</div>		
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/constants/manage_admin_constants.js')!!}
	{!! Html::script('/js/admin/manage_admin.js')!!}
	{!! Html::script('/js/admin/controllers/manage_admin_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_admin_service.js')!!}
@stop