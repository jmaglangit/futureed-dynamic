@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageParentStudentController as student" ng-init="student.active = '{!! $active !!}'" ng-cloak>
		
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="student.setActive('list')" >
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')			
			</div>
			
			<div class="client-content">
				<div template-directive template-url="{!! route('client.parent.student.partials.list_student_form') !!}"></div>

				<div template-directive template-url="{!! route('client.parent.student.partials.add_student_form') !!}"></div>

				<div template-directive template-url="{!! route('client.parent.student.partials.view_student_form') !!}"></div>

				<div template-directive template-url="{!! route('client.parent.student.partials.invitation_code_form') !!}"></div>
				
				<div template-directive template-url="{!! route('client.parent.student.partials.change_email_form') !!}"></div>
			</div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_parent_student_controller.js'. '?size=' . File::size(public_path('/js/client/controllers/manage_parent_student_controller.js')))!!}
	{!! Html::script('/js/client/services/manage_parent_student_service.js'. '?size=' . File::size(public_path('/js/client/services/manage_parent_student_service.js')))!!}
	{!! Html::script('/js/common/table_service.js'. '?size=' . File::size(public_path('/js/common/table_service.js')))!!}
	{!! Html::script('/js/common/search_service.js'. '?size=' . File::size(public_path('/js/common/search_service.js')))!!}
	{!! Html::script('/js/common/validation_service.js'. '?size=' . File::size(public_path('/js/common/validation_service.js')))!!}
	{!! Html::script('/js/client/constants/parent_constants.js'. '?size=' . File::size(public_path('/js/client/constants/parent_constants.js')))!!}
	{!! Html::script('/js/client/student.js'. '?size=' . File::size(public_path('/js/client/student.js')))!!}
@stop