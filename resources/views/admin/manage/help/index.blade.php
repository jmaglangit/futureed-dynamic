@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageHelpRequestController as help" ng-cloak>
  		
  		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>	        

			<div class="price-content" ng-init="help.setActive()">
				<div class="content-title">
					<div class="title-main-content">
						<span><i class="fa fa-gear"></i> Tips & Help Requests</span>
					</div>
				</div>
				<div class="form-content col-xs-12">
					<ul class="nav nav-tabs">
					    <li>
					    	<a href="{!! route('admin.manage.tips.index') !!}"><span><i class="fa fa-lightbulb-o"></i>Tips</span></a>
					    </li>
					    <li class="active">
					    	<a href=""><span><i class="fa fa-database"></i>Help Requests</span></a>
					    </li>
					</ul>
				</div>
					
				<div class="tab-content">
				  	<div class="tab-pane fade in active">
						<div template-directive template-url="{!! route('admin.manage.help.partials.list') !!}"></div>

						<div template-directive template-url="{!! route('admin.manage.help.partials.detail') !!}"></div>
					</div>
			  	</div>
			</div>
		</div>	
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_help_request_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_help_request_service.js')!!}

	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
@stop