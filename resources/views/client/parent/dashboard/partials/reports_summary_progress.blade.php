<div class="summary-progress" ng-if="reports.active_summary_progress">
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
						ng-change="reports.summaryProgress()"
						ng-disabled="!reports.subjects.length"
						class="form-control">
					<option value="">{!! trans('messages.admin_select_subject') !!}</option>
					<option ng-selected="reports.search.subject_id == subject.id"
							ng-repeat="subject in reports.subjects" ng-value="subject.id">{! subject.name !}
					</option>
				</select>
			</div>
		</div>
		{!! Form::close() !!}
	</div>

	<div template-directive template-url="{!! route('client.parent.partials.reports_progress_bar') !!}"></div>

	<div class="reports-container" ng-cloak>
		<div class="progress-holder" ng-repeat="(key, value) in reports.summary.columns track by $index">
			<p>{! value.grade !}</p>

			<div class="progress">
				<div class="progress-bar progress-bar-success"
					 ng-style="{ 'width' : reports.summary.records[key-1].completed }"></div>
				<div class="progress-bar progress-bar-warning"
					 ng-style="{ 'width' : reports.summary.records[key-1].on_going }"></div>
			</div>
		</div>

		<div>
			<p class="progress-key">{!! trans('messages.keys') !!}</p>

			<div class="progress-legends col-xs-4">
				<div class="success-legend">{!! trans('messages.completed') !!}</div>
			</div>
			<div class="progress-legends col-xs-4">
				<div class="ongoing-legend">{!! trans('messages.ongoing') !!}</div>
			</div>

			<div class="progress-legends col-xs-4">
				<div class="not-started-legend">{!! trans('messages.not_yet_started') !!}</div>
			</div>
		</div>
	</div>
</div>