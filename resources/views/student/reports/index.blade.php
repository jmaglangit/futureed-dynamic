@extends('student.app')

@section('navbar')
	@include('student.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con reports" ng-controller="ProfileController as profile" ng-cloak>
		<div class="wrapr">
			<div class="content-title">
				<div class="title-main-content">
					<span><i class="fa fa-file-text-o"></i> My Reports</span>
					<div class="report-options col-xs-6 pull-right top-10">
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
			</div>

			<div class="report-content" ng-controller="StudentReportsController as reports" ng-init="profile.setStudentProfileActive('reports')" template-directive template-url="{!! route('reports.partials.reports_form') !!}"></div>
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