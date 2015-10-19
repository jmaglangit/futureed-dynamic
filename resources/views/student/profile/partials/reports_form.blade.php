<div ng-if="profile.active_reports">
	<ul class="nav nav-pills nav-student" ng-init="reports.setActive()">
		<li role="presentation" ng-class="{ 'active' : reports.active_report_card }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.REPORT_CARD)">Report Card</a></li>
		<li role="presentation" ng-class="{ 'active' : reports.active_summary_progress }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.SUMMARY_PROGRESS)">Summary Progress</a></li>
	</ul>

	<div class="col-xs-12 search-container">
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
	</div>
	 
	<div ng-if="reports.active_report_card">
		<div class="list-container" ng-cloak>
			<div class="size-container">
				{!! Form::select('size'
					, array(
						  '10' => '10'
						, '20' => '20'
						, '50' => '50'
						, '100' => '100'
					)
					, '10'
					, array(
						'ng-model' => 'reports.table.size'
						, 'ng-change' => 'reports.paginateBySize()'
						, 'ng-if' => "reports.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<div class="clearfix"></div>

			<div class="table-responsive">
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
			<div class="reports-pagination" ng-if="reports.records.length">
				<pagination 
					total-items="reports.table.total_items" 
					ng-model="reports.table.page"
					max-size="3"
					items-per-page="reports.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="reports.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>

	<div ng-if="reports.active_summary_progress">
		<br />
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