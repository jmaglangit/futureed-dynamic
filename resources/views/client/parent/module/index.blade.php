@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageParentModuleController as module" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="module.setActive()">
			<div template-directive template-url="{!! route('client.parent.module.partials.list_module_form') !!}"></div>
			<div template-directive template-url="{!! route('client.parent.module.partials.view_module') !!}"></div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_parent_module_controller.js')!!}
	{!! Html::script('/js/client/services/manage_parent_module_service.js')!!}
	{!! Html::script('/js/client/services/profile_service.js')!!}
	
	{!! Html::script('/js/common/validation_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}
@stop