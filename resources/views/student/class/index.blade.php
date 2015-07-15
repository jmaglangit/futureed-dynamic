@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-init="backgroundClass(); checkClass(1)" ng-cloak>

		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
		
		<div ng-controller="StudentClassController as class"  template-directive template-url="{!! route('student.partials.sidebar_nav') !!}"></div>

		<div class="wrapr"> 
			
		</div>
	</div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_class_controller.js')!!}
	{!! Html::script('/js/student/services/student_class_service.js')!!}

	{!! Html::script('/js/student/class.js')!!}
@stop