@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageTeacherController as teacher" ng-cloak>
	
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="teacher.setActive()" >

			<div template-directive template-url="{!! route('client.teacher.partials.list_teacher_form') !!}"></div>

			<div template-directive template-url="{!! route('client.teacher.partials.add_teacher_form') !!}"></div>

			<div template-directive template-url="{!! route('client.teacher.partials.view_teacher_form') !!}"></div>
			
			<div template-directive template-url="{!! route('client.teacher.partials.delete_teacher_form') !!}"></div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/manage_teacher.js')!!}
	{!! Html::script('/js/client/controllers/manage_teacher_controller.js')!!}
	{!! Html::script('/js/client/services/manage_teacher_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/client/constants/teacher_constants.js')!!}
@stop