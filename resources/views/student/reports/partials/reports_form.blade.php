<div ng-if="profile.active_reports">
<!-- <div> -->
	<ul class="nav nav-pills pill-gold-report nav-student" ng-init="reports.setActive()">
		<li role="presentation" ng-class="{ 'active' : reports.active_report_card }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.REPORT_CARD)">
				<i class="fa fa-file-text-o"></i>
				 {!! trans('messages.report_card') !!}</a>
		</li>
		<li role="presentation" ng-class="{ 'active' : reports.active_summary_progress }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.SUMMARY_PROGRESS)">
				<i class="fa fa-list-ul"></i>
				 {!! trans('messages.summary_progress') !!}
			</a>
		</li>
		<li role="presentation" ng-class="{ 'active' : reports.active_subject_area }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.SUBJECT_AREA)">
				<i class="fa fa-book"></i>
				 {!! trans('messages.subject_area') !!}
			</a>
		</li>
		<li role="presentation" ng-class="{ 'active' : reports.active_subject_area_heatmap }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.SUBJECT_AREA_HEATMAP)">
				<i class="fa fa-bookmark"></i>
				Subject Area Heatmap
			</a>
		</li>
		<li role="presentation" ng-class="{ 'active' : reports.active_current_learning }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.CURRENT_LEARNING)">
				<i class="fa fa-bar-chart"></i>
				 {!! trans('messages.current_learning') !!}
			</a>
		</li>
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


	<div template-directive template-url="{!! route('reports.partials.report_card_form') !!}"></div>

	<div template-directive template-url="{!! route('reports.partials.summary_progress_form') !!}"></div>

	<div template-directive template-url="{!! route('reports.partials.subject_area_form') !!}"></div>

	<div template-directive template-url="{!! route('reports.partials.subject_area_heatmap_form') !!}"></div>

	<div template-directive template-url="{!! route('reports.partials.current_learning_form') !!}"></div>

</div>