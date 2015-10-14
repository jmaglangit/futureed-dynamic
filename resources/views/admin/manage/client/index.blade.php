@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageClientController as client" ng-cloak>
  		
  		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="client.setActive()">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>	        

			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.list_client_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.add_client_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.client_details_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.delete_client_form') !!}"></div>	
		</div>		
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_client_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_client_service.js')!!}
	
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/validation_service.js')!!}
@stop