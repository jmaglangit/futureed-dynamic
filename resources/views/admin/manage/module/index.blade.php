@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageModuleController as module" ng-cloak>

		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="module.setActive()">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.module.partials.list_module_form') !!}"></div>
			
			{{-- <div class="client-content" template-directive template-url="{!! route('admin.manage.invoice.partials.view_invoice') !!}"></div> --}}
		
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_module_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_module_service.js')!!}
	
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}
@stop