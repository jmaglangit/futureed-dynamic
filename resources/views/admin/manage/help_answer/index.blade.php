@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageHelpAnswerController as answer" ng-cloak>
		
		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>	        

			<div class="price-content" ng-init="answer.setActive()">
				<div class="content-title">
					<div class="title-main-content">
						<span><i class="fa fa-gear"></i> {!! trans('messages.tips_and_help_request') !!}</span>
					</div>
				</div>
				
				<ul class="nav nav-pills nav-admin">
					<li>
						<a href="{!! route('admin.manage.tips.index') !!}"><span><i class="fa fa-lightbulb-o"></i>{!! trans('messages.tips') !!}</span></a>
					</li>
					<li>
						<a href="{!! route('admin.manage.help.index') !!}"><span><i class="fa fa-question-circle"></i>{!! trans_choice('messages.help_request',1) !!}</span></a>
					</li>
					<li class="active">
						<a href=""><span><i class="fa fa-exclamation-circle"></i>{!! trans('messages.help_request_answers') !!}</span></a>
					</li>
				</ul>
					
				<div class="tab-content">
					<div class="tab-pane fade in active">
						<div template-directive template-url="{!! route('admin.manage.answer.partials.list') !!}"></div>

						<div template-directive template-url="{!! route('admin.manage.answer.partials.detail') !!}"></div>

						<div template-directive template-url="{!! route('admin.manage.answer.partials.delete') !!}"></div>
					</div>
				</div>
			</div>
		</div>	
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_help_answer_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_help_answer_service.js')!!}
@stop