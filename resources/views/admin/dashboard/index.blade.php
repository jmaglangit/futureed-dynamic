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

			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content">
						<span>Admin Dashboard</span>
					</div>
				</div>
			</div>
		</div>		
	</div>
@stop
	
@section('scripts')
	
	{!! Html::script('/js/admin/controllers/dashboard_controller.js')!!}
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js')!!}

@stop