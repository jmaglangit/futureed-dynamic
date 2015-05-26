@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageSubjectController as subject" ng-cloak>
  		
  		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				<div template-directive template-url="{!! route('admin.manage.subject.partials.subject_side_nav') !!}"></div>
			</div>	        

			<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.subject_list_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.add_subject_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.subject_details_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.subject.partials.delete_subject_form') !!}"></div>
		</div>		
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/constants/manage_subject_constants.js')!!}
	{!! Html::script('/js/admin/manage_subject.js')!!}
	{!! Html::script('/js/admin/controllers/manage_subject_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_subject_service.js')!!}
@stop