@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageStudentController as student" ng-cloak>

		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>
		
		<div class="wrapr" ng-init="student.setActive()" >
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.student.partials.list_student_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.student.partials.import_student_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.student.partials.add_student_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.student.partials.view_student_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.student.partials.delete_student_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.student.partials.reward') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.student.partials.edit_reward') !!}"></div>
		</div>
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_student_controller.js' . '?size=' . File::size(public_path('/js/admin/controllers/manage_student_controller.js')))!!}
	{!! Html::script('/js/admin/services/manage_student_service.js' . '?size=' . File::size(public_path('/js/admin/services/manage_student_service.js')))!!}

	{!! Html::script('/js/common/table_service.js' . '?size=' . File::size(public_path('/js/common/table_service.js')))!!}
	{!! Html::script('/js/common/search_service.js' . '?size=' . File::size(public_path('/js/common/search_service.js')))!!}
	{!! Html::script('/js/common/validation_service.js' . '?size=' . File::size(public_path('/js/common/validation_service.js')))!!}
@stop