@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageTeacherStudentController as teacher" ng-init="teacher.active = '{!! $active !!}'" ng-cloak>
		
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="teacher.setActive()" >
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')			
			</div>
			<div class="client-content">
				<div template-directive template-url="{!! route('client.teacher.student.partials.list_student_form') !!}"></div>

				<div template-directive template-url="{!! route('client.teacher.student.partials.view_student_form') !!}"></div>			
				
				<div template-directive template-url="{!! route('client.teacher.student.partials.email_student_form') !!}"></div>		
			</div>	
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_teacher_student_controller.js')!!}
	{!! Html::script('/js/client/services/manage_teacher_student_service.js')!!}

	{!! Html::script('/js/client/constants/teacher_constants.js')!!}
	{!! Html::script('/js/common/validation_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}
@stop