@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageClassController as class" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div template-directive template-url="{!! route('client.teacher.class.partials.list_class_form') !!}"></div>

			<div template-directive template-url="{!! route('client.teacher.class.partials.view_class_form') !!}"></div>

			<div template-directive template-url="{!! route('client.teacher.class.partials.edit_class_form') !!}"></div>

			<div template-directive template-url="{!! route('client.teacher.class.partials.add_student_form') !!}"></div>
			
		</div>
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_class_controller.js')!!}
	{!! Html::script('/js/client/services/manage_class_service.js')!!}
@stop