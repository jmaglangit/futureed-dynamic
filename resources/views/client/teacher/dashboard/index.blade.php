<div ng-if="user.role == futureed.TEACHER" ng-controller="ManageTeacherContentController as dashboard" ng-init="dashboard.setActive(futureed.DASHBOARD)" ng-cloak>
	<div ng-if="!dashboard.active_report" class="dashboard-content">
		<p>To get started on using Future Lesson, you need to add a student under a
		<a href="{!! route('client.teacher.class.index') !!}"> class</a>.</p>

		<p>To see all your students, click
		<a href="{!! route('client.teacher.student.index') !!}"> student</a>.</p>

		<p>To review the lessons and practice questions, click on
		<a href="{!! route('client.teacher.module.index') !!}"> module</a>.</p>
	</div>

	<div ng-if="dashboard.active_report">

		<div class="row client-export-button-container">
			<div class="col-xs-12">
				<div class="btn-group export-buttons pull-right">
					<button class="btn btn-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Export </button>
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

		<div class="report-container">
			<ul class="nav nav-tabs report-nav" role="tablist">
				<li class="col-xs-6 active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-list-ul"></i> View class list</a></li>
				<li class="col-xs-6 class-list">
					<select ng-model="dashboard.classroom_id"
							ng-change="dashboard.getDashboardReport()"
							class="form-control">
						<option value="">-- Select Class --</option>
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
				<h3><i class="fa fa-th-list"></i> Teacher Details</h3>
				<table class="table table-bordered">
					<tr class="magenta-row">
						<th class="col-xs-3">Class Name</th>
						<td>{! dashboard.additional_information.class_name !}</td>
					</tr>
					<tr class="magenta-row">
						<th class="col-xs-3">Class Level</th>
						<td>{! dashboard.additional_information.grade_name !}</td>
					</tr>
				</table>
			</div>

			<!-- student status -->
			<div>
				<h3><i class="fa fa-file-text"></i> Student Status</h3>
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
				<h3><i class="fa fa-user"></i> Students to watch</h3>
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