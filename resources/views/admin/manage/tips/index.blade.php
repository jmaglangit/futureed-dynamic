@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageTipsController as tips" ng-cloak>
  		
  		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>	        

			<div class="client-content" template-directive template-url="{!! route('admin.manage.tips.partials.list') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.tips.partials.detail') !!}"></div>
		</div>		
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_tips_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_tips_service.js')!!}

	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
@stop