@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageTeacherModuleController as module" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="module.setActive()">
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')			
			</div>
			<div class="client-content">
				<div template-directive template-url="{!! route('client.teacher.module.partials.list_module_form') !!}"></div>
				
				<div template-directive template-url="{!! route('client.teacher.module.partials.view_module') !!}"></div>
			</div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_teacher_module_controller.js' . '?size=' . File::size(public_path('/js/client/controllers/manage_teacher_module_controller.js')))!!}
	{!! Html::script('/js/client/services/manage_teacher_module_service.js' . '?size=' . File::size(public_path('/js/client/services/manage_teacher_module_service.js')))!!}
	{!! Html::script('/js/client/services/profile_service.js' . '?size=' . File::size(public_path('/js/client/services/profile_service.js')))!!}
	
	{!! Html::script('/js/common/validation_service.js' . '?size=' . File::size(public_path('/js/common/validation_service.js')))!!}
	{!! Html::script('/js/common/table_service.js' . '?size=' . File::size(public_path('/js/common/table_service.js')))!!}
	{!! Html::script('/js/common/search_service.js' . '?size=' . File::size(public_path('/js/common/search_service.js')))!!}
@stop