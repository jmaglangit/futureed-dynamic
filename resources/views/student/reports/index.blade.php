@extends('student.app')

@section('navbar')
	@include('student.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con reports" ng-controller="ProfileController as profile" ng-cloak>
		<div ng-controller="StudentReportsController as reports" class="wrapr">
			<div class="content-title">
				<div class="title-main-content row">
					<div class="col-xs-6">
						<span><i class="fa fa-file-text-o"></i> My Reports</span>
					</div>

					<div class="col-xs-6">
						<div class="btn-group pull-right export-buttons" ng-if="reports.student_report_export">
							<button class="btn btn-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Export </button>

							<ul class="dropdown-menu">
								<li><a href="{!reports.student_report_export!}/pdf">PDF</a></li>
								<li><a href="{!reports.student_report_export!}/xls">Excel</a></li>
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
@stop