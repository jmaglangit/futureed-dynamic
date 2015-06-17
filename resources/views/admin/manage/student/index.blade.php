@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageStudentController as student" ng-cloak>

		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>
		<div class="wrapr" ng-init="student.setActive('list')" >
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>
				<div class="client-content" template-directive template-url="{!! route('admin.manage.student.partials.list_student_form') !!}"></div>
		</div>
	</div>
@stop
	
@section('scripts')
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js')!!}
	{!! Html::script('/js/admin/controllers/manage_student_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_student_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}

@stop