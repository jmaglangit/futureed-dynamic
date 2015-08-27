@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageClassController as class" ng-init="class.active = '{!! $active !!}'" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="class.setActive()">
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')			
			</div>
			<div class="client-content">
				<div template-directive template-url="{!! route('client.teacher.class.partials.list_class_form') !!}"></div>

				<div template-directive template-url="{!! route('client.teacher.class.partials.view_class_form') !!}"></div>

				<div template-directive template-url="{!! route('client.teacher.class.partials.add_student_form') !!}"></div>
			</div>
		</div>
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_class_controller.js')!!}
	{!! Html::script('/js/client/services/manage_class_service.js')!!}

	{!! Html::script('/js/client/constants/teacher_constants.js')!!}

	{!! Html::script('/js/client/controllers/manage_teacher_tips_controller.js')!!}
	{!! Html::script('/js/client/services/manage_teacher_tips_service.js')!!}
	
	{!! Html::script('/js/client/controllers/manage_teacher_help_controller.js')!!}
	{!! Html::script('/js/client/services/manage_teacher_help_service.js')!!}

	{!! Html::script('/js/client/controllers/manage_teacher_help_answer_controller.js')!!}
	{!! Html::script('/js/client/services/manage_teacher_help_answer_service.js')!!}
	
	{!! Html::script('/js/common/validation_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}
@stop