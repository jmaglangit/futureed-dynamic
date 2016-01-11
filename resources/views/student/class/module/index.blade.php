@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
	<div class="col-xs-12 module-contents-container" ng-controller="StudentModuleController as mod" ng-init="mod.updateBackground();mod.launchModule('{!! $id !!}');" ng-cloak>
		<div template-directive template-url="{!! route('student.partials.base_url') !!}"></div>

		<ul class="breadcrumb">
		    <li><i class="fa fa-home"></i></li>
		    <li>{! mod.record.subject.name !}</li>
		    <li>{! mod.record.name !}</li>
		</ul>

		<div class="col-xs-12" ng-if="mod.active_contents && (mod.errors || mod.success)">
			<div class="alert alert-error" ng-if="mod.errors">
				<p ng-repeat="error in mod.errors track by $index">
					{! error !}
				</p>
			</div>

	        <div class="alert alert-success" ng-if="mod.success">
	            <p>{! mod.success !}</p>
	        </div>
	    </div>
		
		<div class="col-xs-2">
			<div ng-if="!mod.record.module_done">
				<div class="margin-top-bot-5 pointer" 
					ng-class="{ 'disabled-help-bar' : mod.active_contents && !mod.contents }"
					ng-if="!mod.no_record">
					<img src="/images/class-student/icon-askforhelp.png" ng-click="mod.askHelp()">
				</div>
				<div class="margin-top-bot-5 pointer" 
					ng-class="{ 'disabled-tips-bar' : mod.active_contents && !mod.contents }"
					ng-if="!mod.no_record">
					<img src="/images/class-student/icon-givetip.png" ng-click="mod.giveTip()">
				</div>
				<br />
				<div class="btn-menu">
					<div class="pointer" ng-if="!mod.no_record && mod.active_questions && !mod.result.failed">
						<button type="button" class="btn btn-maroon"
							ng-click="mod.reviewContent()"> Review Contents </button>
					</div>
					<div ng-if="mod.active_contents">
						{!! Form::button('Proceed'
							,array(
								'class' => 'btn btn-maroon'
								, 'ng-click' => 'mod.startQuestions()'
								, 'ng-if' => "mod.record.student_module.module_status == 'On Going'"
							)
						)!!}
					</div>
					<div>
						<button type="button" class="btn btn-gold"
							ng-click="mod.exitModule('{!! route('student.class.index') !!}')">Exit Module</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Main Container -->
		<div ng-if="!mod.record.module_done" class="col-xs-9">
			<div ng-if="mod.active_contents">
				<div template-directive template-url="{!! route('student.class.module.partials.contents') !!}"></div>
			</div>

			<div ng-if="mod.active_questions">
				<div template-directive template-url="{!! route('student.class.module.partials.questions') !!}"></div>
			</div>
		</div>
		<!-- End of Main Container -->

		<div class="row" ng-hide="mod.record.module_done || (mod.active_contents && !mod.contents)">
			<div class="drawer col-xs-6" ng-controller="TipsController as tips">
				<div class="drawer-inside" ng-class="{ 'openup' : tips.show_content_tips }">
					<div class="drawer-header pointer" ng-click="tips.toggleTips(mod)">
						<img class="pull-left" ng-src="/images/class-student/icon-tip_principal.png">

						<p class="pull-left">Give Tips</p>	

						<img class="drawer-button" 
							ng-class="{ 'flip-270' : tips.show_content_tips, 'flip-90' : !tips.show_content_tips, }" 
							ng-src="/images/class-student/btn-slide.png">
					</div>

					<div template-directive template-url="{!! route('student.class.module.partials.add_tip') !!}"></div>

					<div template-directive template-url="{!! route('student.class.module.partials.list_tips') !!}"></div>

					<div template-directive template-url="{!! route('student.class.module.partials.view_tip') !!}"></div>
				</div>
			</div>
			<div class="drawer-help col-xs-6" ng-controller="HelpController as help">
				<div class="drawer-inside" ng-class="{ 'openup' : help.show_help_requests }">
					<div class="drawer-header pointer" ng-click="help.toggleHelp(mod)">
						<img class="pull-left" src="/images/class-student/icon-tip_principal.png">
						<p class="pull-left">Help Request</p>	

						<img class="drawer-button" 
							ng-class="{ 'flip-270' : help.show_help_requests, 'flip-90' : !help.show_help_requests }" src="/images/class-student/btn-slide.png">
					</div>
					
					<div template-directive template-url="{!! route('student.class.module.partials.add_help') !!}"></div>

					<div template-directive template-url="{!! route('student.class.module.partials.list_help') !!}"></div>

					<div template-directive template-url="{!! route('student.class.module.partials.view_help') !!}"></div>
				</div>
			</div>
		</div>

		<div template-directive template-url="{!! route('student.class.module.partials.view_question_message') !!}"></div>
	</div>
	<div class="clearfix"></div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_tips_controller.js')!!}
	{!! Html::script('/js/student/services/student_tips_service.js')!!}

	{!! Html::script('/js/student/controllers/student_help_controller.js')!!}
	{!! Html::script('/js/student/services/student_help_service.js')!!}

	{!! Html::script('/js/student/controllers/student_module_controller.js')!!}
	{!! Html::script('/js/student/services/student_module_service.js')!!}

	{!! Html::script('/js/student/constants/student_module_constant.js')!!}
	{!! Html::script('/js/student/constants/student_help_constant.js')!!}

	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}	
	{!! Html::script('//code.jquery.com/ui/1.9.2/jquery-ui.js')!!}
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js')!!}
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.resize.min.js')!!}
@stop

