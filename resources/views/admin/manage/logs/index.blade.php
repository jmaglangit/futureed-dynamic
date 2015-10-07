@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageLogsController as logs" ng-cloak>

		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="logs.setActive()">

			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.logs.partials.list_form') !!}"></div>
		
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_logs_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_logs_service.js')!!}
@stop