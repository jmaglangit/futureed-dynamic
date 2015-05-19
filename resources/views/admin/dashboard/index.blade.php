@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
		<div class="container dshbrd-con" ng-controller="AdminDashboardController as admincon" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')				
			</div>
			<div class="client-content" template-directive template-url="{!! route('admin.dashboard.client_list') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.dashboard.add_client') !!}"></div>
		</div>		
	</div>
@stop

@section('footer')

@overwrite
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/datatables_controller.js')!!}
	{!! Html::script('/js/admin/controllers/dashboard_controller.js')!!}
@stop