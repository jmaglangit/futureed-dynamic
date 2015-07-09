@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageModuleContentController as content" ng-cloak>
  		
  		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>	        

			<div class="price-content">
				<div class="content-title">
					<div class="title-main-content">
						<span><i class="fa fa-gear"></i> Module Content </span>
					</div>
				</div>
				<div class="form-content col-xs-12">
					<ul class="nav nav-tabs">
					    <li class="active">
					    	<a href=""><span><i class="fa fa-lightbulb-o"></i>Tips</span></a>
					    </li>
					    <li>
					    	<a href="{!! route('admin.manage.help.index') !!}"><span><i class="fa fa-question-circle"></i>Help Requests</span></a>
					    </li>
					    <li>
					    	<a href="{!! route('admin.manage.answer.index') !!}"><span><i class="fa fa-exclamation-circle"></i>Help Request Answers</span></a>
					    </li>
					</ul>
				</div>
					
				<div class="tab-content" ng-init="content.setActive()">
				  	<div id="home" class="tab-pane fade in active">
						<div template-directive template-url="{!! route('admin.manage.module.content.partials.list') !!}"></div>

						<div template-directive template-url="{!! route('admin.manage.module.content.partials.detail') !!}"></div>

						<div template-directive template-url="{!! route('admin.manage.module.content.partials.delete') !!}"></div>
					</div>
			  	</div>
			</div>
		</div>		
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_module_content_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_module_content_service.js')!!}
	{!! Html::script('/js/admin/constants/manage_module_content_constants.js')!!}

	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
@stop