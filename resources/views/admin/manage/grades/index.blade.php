@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageGradeController as grade" ng-cloak>
  		
  		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				<div template-directive template-url="{!! route('admin.manage.grades.partials.grade_side_nav') !!}"></div>
			</div>	        

			<div class="client-content" template-directive template-url="{!! route('admin.manage.grades.partials.grade_list_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.grades.partials.add_grade_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.grades.partials.grade_details_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.grades.partials.delete_grade_form') !!}"></div>
		</div>		
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/constants/manage_grade_constants.js')!!}
	{!! Html::script('/js/admin/manage_grade.js')!!}
	{!! Html::script('/js/admin/controllers/manage_grade_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_grade_service.js')!!}
@stop