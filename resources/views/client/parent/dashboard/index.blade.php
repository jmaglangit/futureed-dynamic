<div ng-if="user.role == futureed.PARENT" ng-controller="ManageParentReportsController as reports" ng-init="reports.setActive()">
	<div ng-if="!reports.active_report" class="dashboard-content" ng-cloak>
		<p>
			To get started on using Future Lesson, you need to add a student, click
			<a href="{!! route('client.parent.student.index') !!}"> student</a>.
		</p>

		<p>If you already added a Student, you can
			<a href="{!! route('client.parent.payment.index') !!}"> buy a subject</a> for the your student
		</p>

		<p>You can also
			<a href="{!! route('client.parent.module.index') !!}"> review</a> the lessons and practice questions.
		</p>
	</div>

	<div ng-if="reports.active_report" class="reports">
		<h3>Student Report</h3>
			<div class="student-search">
				<select ng-model="reports.student_id"
					ng-change="reports.changeStudentId()"
					class="form-control">
				<option ng-repeat="student in reports.student_list"
						ng-value="student.id"
						ng-selected="reports.student_id == student.id"
						>{! student.first_name + ' ' +  student.last_name !}
				</option>
			</select>
		</div>

		<div>
			<ul class="nav nav-pills pill-gold-report nav-student">
				<li role="presentation" ng-class="{ 'active' : reports.active_report_card }">
					<a href="javascript:void(0)" ng-click="reports.setActive(futureed.REPORT_CARD)">
						<i class="fa fa-file-text-o"></i>
						 Report Card
					 </a>
				</li>
				<li role="presentation" ng-class="{ 'active' : reports.active_summary_progress }">
					<a href="javascript:void(0)" ng-click="reports.setActive(futureed.SUMMARY_PROGRESS)">
						<i class="fa fa-list-ul"></i>
						 Summary Progress
					</a>
				</li>
				<li role="presentation" ng-class="{ 'active' : reports.active_subject_area }">
					<a href="javascript:void(0)" ng-click="reports.setActive(futureed.SUBJECT_AREA)">
						<i class="fa fa-book"></i>
						 Subject Area
					</a>
				</li>
				<li role="presentation" ng-class="{ 'active' : reports.active_current_learning }">
					<a href="javascript:void(0)" ng-click="reports.setActive(futureed.CURRENT_LEARNING)">
						<i class="fa fa-bar-chart"></i>
						 Current Learning
					</a>
				</li>
			</ul>

			
			<div template-directive template-url="{!! route('client.parent.reports.report_card') !!}"></div>
			<div template-directive template-url="{!! route('client.parent.reports.summary_progress') !!}"></div>
			<div template-directive template-url="{!! route('client.parent.reports.subject_area') !!}"></div>
			<div template-directive template-url="{!! route('client.parent.reports.current_learning') !!}"></div>
		</div>	
	</div>	
</div>