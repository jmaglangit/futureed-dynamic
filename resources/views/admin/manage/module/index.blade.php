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
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.module.partials.add_module_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.module.partials.view_module_form') !!}"></div>
		
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_module_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_module_service.js')!!}
	{!! Html::script('/js/admin/controllers/manage_age_group_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_age_group_service.js')!!}

	{!! Html::script('/js/admin/controllers/manage_module_content_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_module_content_service.js')!!}
	{!! Html::script('/js/admin/constants/manage_module_content_constants.js')!!}
	
	{!! Html::script('/js/admin/controllers/manage_question_ans_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_question_ans_service.js')!!}
	{!! Html::script('/js/admin/constants/manage_module_constants.js')!!}
	
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}
@stop