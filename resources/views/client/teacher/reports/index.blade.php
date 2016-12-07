@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div id="module-cont" class="container dshbrd-con"  ng-controller="ManageTeacherReportsController as reports" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')
			</div>


			<div class="client-content" ng-controller="ProfileController as profile">
				<div class="content-title">
					<div class="title-main-content row">
						<div class="col-xs-6">
							<span>{!! trans('messages.student_report') !!}</span>
						</div>
					</div>
				</div>

				<div class ="content-title " \>
					<div class="form-search">
						<div class="form-group row">
							<div class="col-md-2 title-main-content">
								<h6 class="pull-right"><span> {!! trans('messages.class_name') !!}</span></h6>
							</div>

							<div class="col-xs-4" ng-init="reports.getAllClass()">
								<select
			                    	name="class_id"
			                    	class="form-control"
			                    	ng-model="reports.class_id"
			                    	ng-disabled="!reports.class_list.length"
			                    	ng-init="reports.class_id = reports.class_list[0].class_id"
			                    	ng-change="reports.getAllStudentByClass()">
			                        <option value="">{!! trans('messages.teacher_report_select_class') !!}</option>
			                        <option ng-selected=" reports.class_id == class.id " ng-repeat="class in reports.class_list" ng-value="class.id">{! class.name !}</option>
			                    </select>
							</div>

							<div class="col-md-2 title-main-content">
								<h6 class="pull-right"><span> {!! trans('messages.student_name') !!}</span></h6>
							</div>

							<div class="col-xs-4">
			                    <select
			                    	name="student_id"
			                    	class="form-control"
			                    	ng-disabled="!reports.student_list.length"
			                    	ng-model="reports.student_id"
			                    	ng-change="reports.setActive(futureed.REPORT_CARD)">
			                        <option value="">{!! trans('messages.teacher_report_select_student') !!}</option>
			                        <option ng-selected="reports.student_id == student.student.id" ng-repeat="student in reports.student_list" ng-value="student.student_id">{!! trans('messages.student') !!}  {!+ student.student.user.name !}</option>
			                    </select>
			                </div>
						</div>
					</div>
				</div>
			</div>

			<!-- wrap -->

			<br/>
			<div class = "client-content" >
				<div class="reports col-xs-12 table-container" template-directive template-url="{!! route('teacher.reports.partials.reports_form') !!}"></div>
			</div>

		</div>
	</div>
@stop

@section('scripts')
	{!! Html::script('/js/client/controllers/profile_controller.js') !!}
	{!! Html::script('/js/client/services/profile_service.js') !!}

	{!! Html::script('/js/client/controllers/manage_teacher_class_controller.js')!!}
	{!! Html::script('/js/client/controllers/manage_teacher_reports_controller.js')!!}
	{!! Html::script('/js/client/services/manage_teacher_class_service.js')!!}

	{!! Html::script('/js/client/services/manage_teacher_reports_service.js') !!}

	{!! Html::script('/js/client/constants/teacher_constants.js')!!}

	{!! Html::script('/js/client/controllers/manage_teacher_tips_controller.js')!!}
	{!! Html::script('/js/client/services/manage_teacher_tips_service.js')!!}
	
	{!! Html::script('/js/client/controllers/manage_teacher_help_controller.js')!!}
	{!! Html::script('/js/client/services/manage_teacher_help_service.js')!!}

	{!! Html::script('/js/client/controllers/manage_teacher_help_answer_controller.js')!!}
	{!! Html::script('/js/client/services/manage_teacher_help_answer_service.js')!!}
	
	{!! Html::script('/js/common/validation_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}

	{!! Html::script('/js/common/platform-charts.js') !!}
@stop