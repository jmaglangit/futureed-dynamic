@extends('student.app')

@section('navbar')
	@include('student.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con reports" ng-controller="ProfileController as profile" ng-cloak>
		<div ng-controller="StudentReportsController as reports" class="wrapr">
			<div class="row">
				<div class="col-xs-3">
					<a class="btn btn-blue" href="{!! route('student.dashboard.index') !!}">
						<i class="fa fa-arrow-left"></i> {!! trans('messages.back_to_dashboard') !!}</a>
					</a>
				</div>
				<div class="col-xs-offset-9"></div>
			</div>
			<div class="content-title">
				<div class="title-main-content row">
					<div class="col-xs-6">
						<span><i class="fa fa-file-text-o"></i> {!! trans('messages.my_reports') !!}</span>
					</div>

					<div class="col-xs-6">
						<div class="btn-group pull-right export-buttons" ng-if="reports.student_report_export">
							<button class="btn btn-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> {!! trans('messages.export') !!} </button>

							<ul class="dropdown-menu">
								<li><a href="{!reports.student_report_export!}/pdf">PDF</a></li>
								<li><a href="{!reports.student_report_export!}/xls">Excel</a></li>
							</ul>
						</div>
						<div class="pull-right export-buttons" ng-show="reports.active_lsp_download">
							<a class="btn btn-gold" href="{! reports.student_iassess_report !}">{!! strtoupper(trans('messages.download_lsp_report')) !!}</a>
						</div>
						<div class="btn-group pull-right export-buttons" ng-if="reports.student_question_analysis_export">
							<button class="btn btn-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> {!! trans('messages.export') !!} </button>

							<ul class="dropdown-menu">
								<li><a href="{! reports.student_question_analysis_export_link !}">PDF</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="report-content" ng-init="profile.setStudentProfileActive('reports')" template-directive template-url="{!! route('reports.partials.reports_form') !!}"></div>
		</div>
	</div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/profile_controller.js') !!}
	{!! Html::script('/js/student/services/profile_service.js') !!}

	{!! Html::script('/js/student/controllers/student_reports_controller.js') !!}
	{!! Html::script('/js/student/services/student_reports_service.js') !!}

	{!! Html::script('/js/common/table_service.js') !!}
	{!! Html::script('/js/common/search_service.js') !!}

	{!! Html::script('/js/student/profile.js') !!}

	{!! Html::script('/js/common/platform-charts.js') !!}
@stop