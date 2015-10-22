<div ng-if="profile.active_reports">
	<ul class="nav nav-pills nav-student" ng-init="reports.setActive()">
		<li role="presentation" ng-class="{ 'active' : reports.active_report_card }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.REPORT_CARD)">Report Card</a></li>
		<li role="presentation" ng-class="{ 'active' : reports.active_summary_progress }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.SUMMARY_PROGRESS)">Summary Progress</a></li>
	</ul>

	<div ng-if="reports.errors || reports.success">
		<div class="alert alert-error" ng-if="reports.errors">
			<p ng-repeat="error in reports.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="reports.success">
			<p>{! reports.success !}</p>
		</div>
	</div>
	 
	<div ng-if="reports.active_report_card">
		<div class="form-search report-card-container">
			{!! Form::open(
					[
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'reports.searchFnc($event)'
					]
			) !!}
			<div class="form-group">
				<div class="col-xs-3">
					<img ng-src="{! reports.student.avatar_thumbnail !}" />
				</div>
				<div class="col-xs-9">
					<fieldset>
						<legend>{! reports.student.student_name!}</legend>
						<p>{! reports.student.grade_level!}</p>
					</fieldset>
				</div>
			</div>
			{!! Form::close() !!}
		</div>

		<br />

		<div class="list-container" ng-cloak>
			<table id="tip-list" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Subject</th>
						<th>Module Status</th>
						<th>Points Earned</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="data in reports.records">
						<td>{! data.name !}</td>
						<td>{! data.module_status !}</td>
						<td>{! data.points_earned !}</td>
					</tr>
					<tr class="odd" ng-if="!reports.records.length && !reports.table.loading">
						<td valign="top" colspan="7">
							No records found
						</td>
					</tr>
					<tr class="odd" ng-if="reports.table.loading">
						<td valign="top" colspan="7">
							Loading...
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div ng-if="reports.active_summary_progress">
		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'reports.searchFnc($event)'
					]
			) !!}
			<div class="form-group">
				<div class="col-xs-3"></div>
				<div class="col-xs-6">
					<select ng-model="reports.search.subject_id" 
						ng-change="reports.summaryProgress()"
						ng-disabled="!reports.subjects.length"
						class="form-control">
						<option value="">-- Select Subject --</option>
						<option ng-selected="reports.search.subject_id == subject.id" ng-repeat="subject in reports.subjects" ng-value="subject.id">{! subject.name !}</option>
					</select>
				</div>
			</div>
			{!! Form::close() !!}
		</div>

		<div class="reports-container" ng-cloak>
			<div class="progress-holder" ng-repeat="(key, value) in reports.summary.columns track by $index">
			  	<p>{! value !}</p>
			  	<div class="progress">
				  	<div class="progress-bar progress-bar-success"
						ng-style="{ 'width' : reports.summary.records[key].completed }"></div>
				  	<div class="progress-bar progress-bar-warning" 
				  		ng-style="{ 'width' : reports.summary.records[key].on_going }"></div>
				</div>
			</div>

			<div class="row">
				<p class="progress-key">Keys</p>
				<div class="progress-legends col-xs-4">
					<div class="success-legend"> Completed </div>
				</div>
				<div class="progress-legends col-xs-4">
					<div class="ongoing-legend"> Ongoing </div>
				</div>

				<div class="progress-legends col-xs-4">
					<div class="not-started-legend"> Not yet started </div>
				</div>
			</div>
		</div>
	</div>
</div>