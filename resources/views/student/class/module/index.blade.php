@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
	<div class="col-xs-12" ng-init="backgroundClass(); checkClass(1)" ng-controller="StudentModuleController as mod" ng-cloak>
		<div template-directive template-url="{!! route('student.partials.base_url') !!}"></div>

		<div ng-init="mod.setActive(futureed.ACTIVE_CONTENTS, '{!! $id !!}')" ng-if="!mod.no_record">
			<ul class="breadcrumb">
			    <li><a href="#"><span><i class="fa fa-home"></i></span></a></li>
			    <li><a href="#">United States</a></li>
			    <li class="active">Math</li>
			</ul>
		</div>
		
		<div class="col-xs-2">
			<div class="margin-top-bot-5" ng-if="!mod.no_record">
				<a href="javascript:;"><img src="/images/class-student/icon-askforhelp.png" ng-click="mod.askHelp()"></a>
			</div>
			<div class="margin-top-bot-5 pointer" ng-if="!mod.no_record">
				<img src="/images/class-student/icon-givetip.png" ng-click="mod.giveTip()">
			</div>
		</div>
		<!-- Main Container -->
		<div ng-if="mod.active_contents">
			<div template-directive template-url="{!! route('student.class.module.partials.contents') !!}"></div>
		</div>

		<div ng-if="mod.active_questions">
			<div template-directive template-url="{!! route('student.class.module.partials.questions') !!}"></div>
		</div>
		<!-- End of Main Container -->

		<div class="row" ng-if="!mod.no_record">
			<div class="drawer col-xs-6">
				<div class="button" id="button">
					<img ng-click="mod.toggleBtn()" class="pointer" ng-class="{'flip-270':mod.toggle_bottom,'flip-90':!mod.toggle_bottom, }" src="/images/class-student/btn-slide.png">
				</div>
				<div class="drawer-appear">
					<div class="drawer-inside" ng-class="{'openup' : mod.toggle_bottom}">
						<div class="drawer-header">
							<div class="row">
								<div class="margin-top-5">
									<img class="pull-left" src="/images/class-student/icon-tip_principal.png">
									<h3 class="pull-left">Give Tips</h3>	
								</div>
							</div>
						</div>
						<div template-directive template-url="{!! route('student.class.module.partials.add_tip') !!}"></div>
						<div template-directive template-url="{!! route('student.class.module.partials.list_tips') !!}"></div>
					</div>
				</div>
			</div>
			<div class="drawer-help col-xs-6">
				<div class="button" id="button">
					<img ng-click="mod.toggleBtnHelp()" class="pointer" ng-class="{'flip-270':mod.toggle_help_bottom,'flip-90':!mod.toggle_help_bottom, }" src="/images/class-student/btn-slide.png">
				</div>
				<div class="drawer-appear">
					<div class="drawer-inside" ng-class="{'openup' : mod.toggle_help_bottom}">
						<div class="drawer-header">
							<div class="row">
								<div class="margin-top-5">
									<img class="pull-left" src="/images/class-student/icon-tip_principal.png">
									<h3 class="pull-left">Help Request</h3>	
								</div>
							</div>
						</div>
						<div template-directive template-url="{!! route('student.class.module.partials.add_help') !!}"></div>
						<div template-directive template-url="{!! route('student.class.module.partials.list_help') !!}"></div>
					</div>
				</div>
			</div>
		</div>

		<div template-directive template-url="{!! route('student.class.module.partials.view_question_message') !!}"></div>
	</div>
	<div class="clearfix"></div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_module_controller.js')!!}
	{!! Html::script('/js/student/services/student_module_service.js')!!}
	{!! Html::script('/js/student/constants/student_module_constant.js')!!}

	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}	
@stop

