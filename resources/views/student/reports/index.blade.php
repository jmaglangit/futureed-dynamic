@extends('student.app')

@section('navbar')
	@include('student.partials.main-nav')
@stop

@section('content')
	<div id="student-reports" class="container dshbrd-con" ng-controller="ProfileController as profile" ng-cloak>
		<div class="wrapr">
			<div class="title-main-content">
				<div class="report-title col-xs-6">
					<h3><i class="fa fa-file-text-o"></i> My Reports</h3>
				</div>

				<div class="report-options col-xs-6 pull-right">
					<ul>
						<li>
							<button class="btn btn-blue"><i class="fa fa-save"></i> Save </button>
						</li>
						<li>
							<button class="btn btn-blue"><i class="fa fa-file-pdf-o"></i> Export </button>
						</li>
						<li>
							<button class="btn btn-blue"><i class="fa fa-print"></i> Print </button>
						</li>
						<li>
							<button class="btn btn-blue"><i class="fa fa-envelope-o"></i> Email </button>
						</li>
					</ul>
				</div>
			</div>

			<div class="reports" ng-controller="StudentReportsController as reports" ng-init="profile.setStudentProfileActive('reports')" template-directive template-url="{!! route('student.reports.reports_form') !!}"></div>
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