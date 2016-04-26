<div ng-if="user.role == futureed.TEACHER" ng-controller="ManageTeacherContentController as dashboard" ng-init="dashboard.setActive(futureed.DASHBOARD)" ng-cloak>
	<div ng-if="!dashboard.active_report" class="dashboard-content">

		<div class="col-xs-12 row">
			<div class="col-xs-8">
				<h5>
					To get started on using Future Lesson, you need to add a student.
				</h5>
			</div>
			<div class="col-xs-4">
				<a class="dashboard-content-btn" href="{!! route('client.teacher.class.index') !!}">
					<button  type="button">
						Add student now!
					</button>
				</a>
			</div>
		</div>

		<div class="col-xs-12 row">
			<div class="col-xs-8">
				<h5>
					To see all your students, click student.
				</h5>
			</div>
			<div class="col-xs-4">
				<a class="dashboard-content-btn" href="{!! route('client.teacher.student.index') !!}">
					<button  type="button">
						Student List
					</button>
				</a>
			</div>
		</div>

		<div class="col-xs-12 row">
			<div class="col-xs-8">
				<h5>
					To review the lessons and practice questions, click the module.
				</h5>
			</div>
			<div class="col-xs-4">
				<a class="dashboard-content-btn" href="{!! route('client.teacher.module.index') !!}">
					<button  type="button">
						Module
					</button>
				</a>
			</div>
		</div>

		<div class="clearfix"></div>

	</div>

	<div ng-if="dashboard.active_report">

		<div class="row client-export-button-container">
			<div class="col-xs-12">
				<div class="btn-group export-buttons pull-right">
					<button class="btn btn-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> {!! trans('messages.export') !!} </button>
					<ul class="dropdown-menu">
						<li><a href="{!dashboard.teacher_report_export!}/pdf">PDF</a></li>
						<li><a href="{!dashboard.teacher_report_export!}/xls">Excel</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div ng-if="dashboard.export" class="report-options">
			<ul class="pull-right">
				<li>
					<button class="btn btn-blue"><i class="fa fa-save"></i> {!! trans('messages.save') !!} </button>
				</li>
				<li>
					<button class="btn btn-blue"><i class="fa fa-file-pdf-o"></i> {!! trans('messages.export') !!} </button>
				</li>
				<li>
					<button class="btn btn-blue"><i class="fa fa-print"></i> {!! trans('messages.print') !!} </button>
				</li>
				<li>
					<button class="btn btn-blue"><i class="fa fa-envelope-o"></i> {!! trans('messages.email') !!} </button>
				</li>
			</ul>
		</div>

		<div class="report-container">
			<ul class="nav nav-tabs report-nav" role="tablist">
				<li class="col-xs-6 active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-list-ul"></i> {!! trans('messages.client_view_class_list') !!}</a></li>
				<li class="col-xs-6 class-list">
					<select ng-model="dashboard.classroom_id"
							ng-change="dashboard.getDashboardReport()"
							class="form-control">
						<option value="">{!! trans('messages.select_class') !!}</option>
						<option ng-selected="dashboard.classroom_id == class.id"
								ng-repeat="class in dashboard.class_list"
								ng-value="class.id">
								{! class.name !}
						</option>
					</select>
				</li>
			</ul>

			<!-- teacher details -->
			<div>
				<h3><i class="fa fa-th-list"></i> {!! trans('messages.client_teacher_details') !!}</h3>
				<table class="table table-bordered">
					<tr class="magenta-row">
						<th class="col-xs-3">{!! trans('messages.class_name') !!}</th>
						<td>{! dashboard.additional_information.class_name !}</td>
					</tr>
					<tr class="magenta-row">
						<th class="col-xs-3">{!! trans('messages.class_level') !!}</th>
						<td>{! dashboard.additional_information.grade_name !}</td>
					</tr>
				</table>
			</div>

			<!-- student status -->
			<div>
				<h3><i class="fa fa-file-text"></i> {!! trans('messages.student_status') !!}</h3>
				<table class="table table-bordered">
					<thead>
						<tr class="magenta">
							<th class="col-xs-6">{! dashboard.column_header.student_progress.name !}</th>
							<th class="col-xs-6">{! dashboard.column_header.student_progress.status !}</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="student in dashboard.record.student_progress">
							<td>{! student.first_name !} {! student.last_name !}</td>
							<td>{! student.progress !}</td>
						</tr>
					</tbody>
				</table>	
			</div>

			<!-- students to watch-->
			<div>
				<h3><i class="fa fa-user"></i> {!! trans('messages.student_to_watch') !!}</h3>
				<table class="table table-bordered">
					<tr class="magenta-row">
						<th class="col-xs-3">{! dashboard.column_header.student_watch.struggling !}</th>
						<td>{! dashboard.record.student_watch.excelling !}</td>
					</tr>
					<tr class="magenta-row">
						<th class="col-xs-3">{! dashboard.column_header.student_watch.excelling !}</th>
						<td>{! dashboard.record.student_watch.struggling !}</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>