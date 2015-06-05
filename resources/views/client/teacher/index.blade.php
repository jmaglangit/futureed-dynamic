@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageTeacherController as teacher" ng-cloak>
	
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="teacher.setActive()" >
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')				
			</div>

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