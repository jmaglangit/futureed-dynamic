@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageParentStudentController as student" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="student.setActive('list')" >

			<div template-directive template-url="{!! route('client.parent.student.partials.list_student_form') !!}"></div>		
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_parent_student_controller.js')!!}
	{!! Html::script('/js/client/services/manage_parent_student_service.js')!!}
@stop