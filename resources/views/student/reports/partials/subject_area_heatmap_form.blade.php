<div class="subject-area" ng-if="reports.active_subject_area_heatmap">
	<div class="form-search magenta">
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
						ng-change="reports.subjectAreaHeatmap()"
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

	<div template-directive template-url="{!! route('reports.partials.progress_bar') !!}"></div>

	<div class="reports-container" ng-cloak>
		<table id="tip-list" class="table table-striped table-bordered">
			<thead>
			<tr>
				<th ng-repeat="column in reports.summary.columns">{! column.name !}</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="data in reports.summary.records ">

				<td>{! data.curriculum_name !}</td>

				<td ng-repeat="(key, value) in reports.summary.columns " ng-if="key > 0">
					<div ng-repeat="(dataKey, dataValue) in data.curriculum_data" ng-if="dataValue.grade_id == value.id">
						<div class="report-progress">
							<div ng-if="dataValue.heat_map" class="progress-bar progress-bar-striped"
								 ng-class="{
										'progress-bar-success' : dataValue.heat_map > 81,
										'progress-bar-warning' : dataValue.heat_map > 51 && dataValue.heat_map <= 80 ,
										'progress-bar-danger' : dataValue.heat_map <= 50 ,
									}"
								 ng-style="{ 'width' : dataValue.heat_map + '%' }">{! dataValue.heat_map !}%</div>
						</div>
					</div>
				</td>
			</tr>

			</tbody>
		</table>
	</div>
</div>