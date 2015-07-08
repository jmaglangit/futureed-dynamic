@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-init="backgroundClass()" ng-controller="StudentClassController as class" ng-cloak>

		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
		
		<div template-directive template-url="{!! route('student.class.partials.dashbrd-side-nav') !!}"></div>

		<div class="wrapr"> 
			
		</div>
	</div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_class_controller.js')!!}
	{!! Html::script('/js/student/services/student_class_service.js')!!}

	{!! Html::script('/js/student/class.js')!!}
@stop