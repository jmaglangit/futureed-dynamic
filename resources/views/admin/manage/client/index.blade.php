@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="AdminClientController as client" ng-cloak>
  		
  		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				<div template-directive template-url="{!! route('admin.manage.client.partials.side_nav') !!}"></div>
			</div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.list_client_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.add_client_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.edit_email_form') !!}"></div>
				
			<!-- <div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.confirm_email_form') !!}"></div> -->
		</div>		
	</div>
@stop

@section('footer')	
	
@section('scripts')
	{!! Html::script('/js/admin/admin_client_constants.js')!!}
	{!! Html::script('/js/admin/admin_client.js')!!}
	{!! Html::script('/js/admin/controllers/datatables_controller.js')!!}
	{!! Html::script('/js/admin/controllers/admin_client_controller.js')!!}
	{!! Html::script('/js/admin/services/admin_client_service.js')!!}
@stop