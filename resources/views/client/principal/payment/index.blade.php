@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManagePaymentController as payment" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="teacher.setActive('list')" >

			<div template-directive template-url="{!! route('client.principal.payment.partials.payment_form') !!}"></div>
			<div template-directive template-url="{!! route('client.principal.payment.partials.add_payment_form') !!}"></div>
			
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_payment_controller.js')!!}
	{!! Html::script('/js/client/services/manage_payment_service.js')!!}
@stop