<div ng-if="user.role == futureed.TEACHER" class="dashboard-content" ng-cloak>
    <p>To get started on using Future Lesson, you need to add a student under a
        <a href="{!! route('client.teacher.class.index') !!}"> class</a>.</p>

    <p>To see all your students, click
        <a href="{!! route('client.teacher.student.index') !!}"> student</a>.</p>

    <p>To review the lessons and practice questions, click on
        <a href="{!! route('client.teacher.module.index') !!}"> module</a>.</p>
</div>

<div ng-if="user.role == futureed.TEACHER" ng-controller="ManageTeacherClassController as report" ng-init="report.getClassReport(13)">
	<div>
		<div class="report-options">
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
					<select class="form-control">
						<option> Test </option>
					</select>
				</li>
			</ul>

			<!-- teacher details -->
			<div>
				<h3><i class="fa fa-th-list"></i> Teacher Details</h3>
				<table class="table table-bordered">
					<tr>
						<td class="col-xs-3">Class Name</td>
						<td>Lorem ipsum blah blah...</td>
					</tr>
					<tr>
						<td class="col-xs-3">Class Level</td>
						<td>Lorem ipsum blah blah...</td>
					</tr>
				</table>
			</div>

			<!-- student status -->
			<div>
				<h3><i class="fa fa-file-text"></i> Student Status</h3>
				<table class="table table-bordered">
					<tr class="magenta">
						<td class="col-xs-4">Student Name</td>
						<td class="col-xs-4">Status</td>
						<td class="col-xs-4">Other Details</td>
					</tr>
					<tr ng-repeat="student in report.studentList">
						<td>{! student.first_name !} {! student.last_name !}</td>
						<td>{! student.progress !}</td>
						<td>test</td>
					</tr>
				</table>	
			</div>

			<!-- students to watch-->
			<div>
				<h3><i class="fa fa-user"></i> Students to watch</h3>
				<table class="table table-bordered">
					<tr>
						<td class="col-xs-3">Excelling</td>
						<td>Lorem ipsum blah blah...</td>
					</tr>
					<tr>
						<td class="col-xs-3">Struggling</td>
						<td>Lorem ipsum blah blah...</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>