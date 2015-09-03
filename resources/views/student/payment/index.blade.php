@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="StudentPaymentController as payment" ng-cloak>

		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="payment.setActive()"> 

			<div template-directive template-url="{!! route('student.payment.partials.list') !!}"></div>

			<div template-directive template-url="{!! route('student.payment.partials.add') !!}"></div>
			
			<div template-directive template-url="{!! route('student.payment.partials.view') !!}"></div>
		</div>
	</div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_payment_controller.js')!!}
	{!! Html::script('/js/student/services/student_payment_service.js')!!}

	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
@stop