<div class="current-learning" ng-if="reports.active_current_learning">
	<div class="reports-container" ng-cloak>
		<table id="tip-list" class="table table-striped">
			<thead>
			<tr>
				<!-- <th ng-repeat="column in reports.summary.columns">{! column !}</th> -->
				<th>{! reports.summary.columns.grade_level !}</th>
				<th>{! reports.summary.columns.curriculum_category !}</th>
				<th>{! reports.summary.columns.percent_completed !}</th>
				<th>
					<div>
						{!! Form::open(
								[
									'id' => 'search_form',
									'class' => 'form-horizontal'
									, 'ng-submit' => 'reports.searchFnc($event)'
								]
						) !!}
						<div class="form-group">
							<!-- <div class="col-xs-2"></div> -->
							<div class="col-xs-12">
								<select ng-model="reports.search.subject_id"
										ng-change="reports.currentLearning()"
										ng-disabled="!reports.subjects.length"
										class="form-control">
									<option value="">-- Select Subject --</option>
									<option ng-selected="reports.search.subject_id == subject.id"
											ng-repeat="subject in reports.subjects" ng-value="subject.id">{! subject.name !}
									</option>
								</select>
							</div>
						</div>
						{!! Form::close() !!}
					</div>
				</th>
			</tr>
			</thead>
			<tbody>
				<tr ng-repeat="data in reports.summary.records ">
					<td>{! data.grade_name !}</td>
					<td>
						<div class="pull-left category-info">
							<img src="{! data.icon_image !}" />
							<span>{! data.name !}</span>
						</div>
					</td>
					<td ng-if=" data.progress == 0 || data.progress || !data.progress">
						<div ng-if="data.progress == 0 || !data.progress">
							<div>{! '' !}</div>
						</div>
						<div ng-if="data.progress">
							{! data.progress !}% Completed
						</div>
					</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>