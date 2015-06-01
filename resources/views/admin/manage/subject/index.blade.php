@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageSubjectController as subject" ng-cloak>
  		
  		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>	        

			<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.subject_list_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.add_subject_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.subject_details_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.delete_subject_form') !!}"></div>
		

			<div ng-controller="ManageSubjectAreaController as area">
				<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.subject_area_list_form') !!}"></div>
				
				<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.subject_area_delete_form') !!}"></div>
			
				<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.subject_area_add_form') !!}"></div>
		
				<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.subject_area_details_form') !!}"></div>
			</div>
		</div>		
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/constants/manage_subject_constants.js')!!}
	{!! Html::script('/js/admin/manage_subject.js')!!}
	{!! Html::script('/js/admin/controllers/manage_subject_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_subject_service.js')!!}
	{!! Html::script('/js/admin/controllers/manage_subject_area_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_subject_area_service.js')!!}
@stop