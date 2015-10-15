@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="SalesController as sale" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')				
			</div>
			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content">
						<span><i class="fa fa-gear"></i> Price & Discounts</span>
					</div>
				</div>

				
				<ul class="nav nav-pills nav-admin">
					<li class="active">
						<a ng-click="sale.setActive('price_settings')" href="javascript:void(0)"><span><i class="fa fa-dollar"></i>Price Settings</span></a></li>
					<li>
						<a ng-click="sale.setActive('client_discount')" href="javascript:void(0)"><span><i class="fa fa-tags"></i>Client Discount</span></a></li>
					<li>
						<a ng-click="sale.setActive('bulk_settings')" href="javascript:void(0)"><span><i class="fa fa-database"></i>Bulk Settings</span></a></li>
				</ul>
					
				<div ng-controller="ManagePriceController as price" ng-init="price.setActive()" 
					template-directive template-url="{!! route('admin.manage.price.partials.price_settings') !!}"></div>

				<div template-directive template-url="{!! route('admin.manage.price.partials.client_discount') !!}"></div>
				
				<div template-directive template-url="{!! route('admin.manage.price.partials.bulk_discount') !!}"></div>

			</div>
		</div>
	</div>
@stop
	
@section('scripts')
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js')!!}
	{!! Html::script('/js/admin/controllers/manage_price_controller.js')!!}

	{!! Html::script('/js/admin/controllers/sales_controller.js')!!}
	{!! Html::script('/js/admin/services/sales_service.js')!!}
	
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}

@stop