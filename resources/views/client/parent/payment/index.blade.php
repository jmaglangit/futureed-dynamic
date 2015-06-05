@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageParentPaymentController as payment" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="payment.setActive('list')" >

			<div template-directive template-url="{!! route('client.parent.payment.partials.payment_form') !!}"></div>
			<div template-directive template-url="{!! route('client.parent.payment.partials.add_payment_form') !!}"></div>
			
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_parent_payment_controller.js')!!}
	{!! Html::script('/js/client/services/manage_parent_payment_service.js')!!}
@stop