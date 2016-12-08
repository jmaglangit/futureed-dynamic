<div ng-if="reports.class_list.length && reports.student_id">
	<ul class="nav nav-pills pill-gold-report nav-student font-size-smaller">
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
				{{ trans('messages.subject_area_heatmap') }}
			</a>
		</li>
		<li role="presentation" ng-class="{ 'active' : reports.active_current_learning }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.CURRENT_LEARNING)">
				<i class="fa fa-bar-chart"></i>
				 {!! trans('messages.current_learning') !!}
			</a>
		</li>
		<li role="presentation" ng-class="{ 'active' : reports.active_question_analysis }">
			<a href="javascript:void(0)" ng-click="reports.setActive(futureed.QUESTION_ANALYSIS)">
				<i class="fa fa-list-alt"></i>
				{!! trans('messages.question_analysis') !!}
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


	<div template-directive template-url="{!! route('teacher.reports.partials.report_card_form') !!}"></div>

	<div template-directive template-url="{!! route('teacher.reports.partials.summary_progress_form') !!}"></div>

	<div template-directive template-url="{!! route('teacher.reports.partials.subject_area_form') !!}"></div>

	<div template-directive template-url="{!! route('teacher.reports.partials.subject_area_heatmap_form') !!}"></div>

	<div template-directive template-url="{!! route('teacher.reports.partials.current_learning_form') !!}"></div>

	<div template-directive template-url="{!! route('teacher.reports.partials.question_analysis') !!}"></div>
</div>

<div ng-if="!reports.class_id">
	<h4 class="title-main-content"><p class="text-center">{!! trans('messages.teacher_no_class') !!}</p></h4>
</div>

<div ng-if="reports.class_id && !reports.student_id">
	<h4 class="title-main-content"><p class="text-center">{!! trans('messages.teacher_no_student') !!}</p></h4>
</div>

