<div class="report-card" ng-if="reports.active_report_card">
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
					<legend> {!! trans('messages.student') !!} {! reports.student.student_name!}</legend>
					<p ng-if="reports.student.grade_level != futureed.NONE">{! reports.student.grade_level!}</p>
				</fieldset>
			</div>
		</div>
		{!! Form::close() !!}
	</div>

	<br/>
	{{--Charts--}}
	<div>
		<div>
			{{--hours chart--}}
			<div class="col-xs-6" template-directive template-url="{!! route('teacher.reports.partials.charts.platform-chart-monthly') !!}"></div>
			<div class="col-xs-6" template-directive template-url="{!! route('teacher.reports.partials.charts.platform-chart-weekly') !!}"></div>
		</div>
		<div>
			{{--subject area--}}
			<div class="col-xs-6" template-directive template-url="{!! route('teacher.reports.partials.charts.platform-chart-subject-area') !!}"></div>
			<div class="col-xs-6" template-directive template-url="{!! route('teacher.reports.partials.charts.platform-chart-subject-area-heatmap') !!}"></div>
		</div>

	</div>

	<br/>

	<div class="list-container" ng-cloak>
		<table id="tip-list" class="table table-striped table-bordered">
			<thead>
			<tr class="magenta">
				<th>{!! trans('messages.subject') !!}</th>
				<th>{!! trans('messages.module_status') !!}</th>
				<th>{!! trans('messages.admin_points_earned') !!}</th>
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
					{!! trans('messages.no_records_found') !!}
				</td>
			</tr>
			<tr class="odd" ng-if="reports.table.loading">
				<td valign="top" colspan="7">
					{!! trans('messages.loading') !!}
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>