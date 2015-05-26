@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')				
			</div>
			<div class="price-content"  ng-controller="SalesController as sale">
				<div class="content-title">
					<div class="title-main-content">
						<span ng-if="!sale.edit_price"><i class="fa fa-gear"></i> Price & Discounts</span>
						<span ng-if="sale.edit_price"><i class="fa fa-gear"></i> Edit Price</span>
					</div>
				</div>
				<div class="form-content col-xs-12">
					<div class="alert alert-danger" ng-if="sale.errors">
						<p ng-repeat="error in sale.errors">
							{! error !}
						</p>
					</div>
					<div class="alert alert-success" ng-if="sale.is_success">
						<p>
							{! sale.is_success !}
						</p>
					</div>
					<ul class="nav nav-tabs">
					    <li class="active"><a data-toggle="pill" href="#home"><span><i class="fa fa-dollar"></i>Price Settings</span></a></li>
					    <li><a data-toggle="pill" href="#discount"><span><i class="fa fa-tags"></i>Client Discount</span></a></li>
					    <li><a data-toggle="pill" href="#bulk"><span><i class="fa fa-database"></i>Bulk Settings</span></a></li>
					  </ul>
					  <div class="tab-content">
					  	<div id="home" class="tab-pane fade in active">
    						<div template-directive template-url="{!! route('admin.manage.price.partials.price_settings') !!}"></div>
    						<div template-directive template-url="{!! route('admin.manage.price.partials.edit_price') !!}"></div>
    					</div>
				    <div id="discount" class="tab-pane fade">
				      	<div template-directive template-url="{!! route('admin.manage.price.partials.client_discount') !!}"></div>
				    </div>
				    <div id="bulk" class="tab-pane fade">
				      <div template-directive template-url="{!! route('admin.manage.price.partials.bulk_discount') !!}"></div>
				      <div template-directive template-url="{!! route('admin.manage.price.partials.bulk_edit') !!}"></div>
				    </div>
				  </div>
				</div>
				</div>
			</div>
		</div>		
	</div>
@stop

@section('footer')

@overwrite
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/dashboard_controller.js')!!}
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js')!!}
	{!! Html::script('/js/admin/controllers/sales_controller.js')!!}
	{!! Html::script('/js/admin/services/sales_service.js')!!}

@stop