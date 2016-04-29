<div ng-if="user.role == futureed.PARENT" ng-controller="ManageParentReportsController as reports" ng-init="reports.setActive()">
	<div ng-if="!reports.active_report" class="dashboard-content" ng-cloak>
		<div class="col-xs-12 row">
			<div class="col-xs-8">
				<h5>
					{{ trans('messages.parent_dashboard_instruction_1') }}
				</h5>
			</div>
			<div class="col-xs-4">
				<a class="dashboard-content-btn" href="{!! route('client.parent.student.index') !!}">
					<button  type="button">
						{{ trans('messages.parent_dashboard_add_student') }}
					</button>
				</a>
			</div>
		</div>

		<div class="col-xs-12 row">
			<div class="col-xs-8">
				<h5>{{ trans('messages.parent_dashboard_instruction_2') }}</h5>
			</div>
			<div class="col-xs-4">
				<a href="{!! route('client.parent.payment.index') !!}" class="dashboard-content-btn">
					<button type="button">
						{{ trans('messages.parent_dashboard_buy_subject') }}
					</button>
				</a>
			</div>
		</div>

		<div class="col-xs-12 row">
			<div class="col-xs-8">
				<h5>
					{{ trans('messages.parent_dashboard_instruction_3') }}
				</h5>
			</div>
			<div class="col-xs-4">
				<a href="{!! route('client.parent.module.index') !!}" class="dashboard-content-btn">
					<button type="button">
						{{ trans('messages.parent_dashboard_review') }}
					</button>
				</a>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div ng-if="reports.active_report" class="reports">
		<h3>{!! trans('messages.student_report') !!}</h3>
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
						 {!! trans('messages.report_card') !!}
					 </a>
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
			</ul>

			
			<div template-directive template-url="{!! route('client.parent.partials.reports_report_card') !!}"></div>
			<div template-directive template-url="{!! route('client.parent.partials.reports_summary_progress') !!}"></div>
			<div template-directive template-url="{!! route('client.parent.partials.reports_subject_area') !!}"></div>
			<div template-directive template-url="{!! route('client.parent.partials.reports_subject_area_heatmap') !!}"></div>
			<div template-directive template-url="{!! route('client.parent.partials.reports_current_learning') !!}"></div>
		</div>	
	</div>	
</div>