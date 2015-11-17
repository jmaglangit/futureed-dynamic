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
				<img ng-src="{! reports.student.avatar_thumbnail !}"/>
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

	<br/>

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