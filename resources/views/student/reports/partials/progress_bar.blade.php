<div class="progress-container">
	<h3 ng-if="reports.student.student_name">{! reports.student.student_name!} Progress in Future Lesson Curriculum</h3>
	<h3 ng-if="reports.student.first_name">{! reports.student.first_name!} {! reports.student.last_name!} Progress in Future Lesson Curriculum</h3>
	<div class="row">
		<div class="progress-item-container col-xs-2">
			<div class="progress-item">
				<div class="circle">
					<span>{! reports.student.earned_badges!}</span>
				</div>
				<p>{!! trans('messages.client_badges_earned') !!}</p>
			</div>
		</div>
		<div class="progress-item-container col-xs-2">
			<div class="progress-item">
				<div class="circle">
					<span>{! reports.student.earned_medals!}</span>
				</div>
				<p>{!! trans('messages.client_no_medals_earned') !!}</p>
			</div>
		</div>
		<div class="progress-item-container col-xs-2">
			<div class="progress-item">
				<div class="circle">
					<span>{! reports.student.completed_lessons !}</span>
				</div>
				<p>{!! trans('messages.client_lessons_completed') !!}</p>
			</div>
		</div>
		<div class="progress-item-container col-xs-2">
			<div class="progress-item">
				<div class="circle">
					<span>{! reports.student.written_tips!}</span>
				</div>
				<p>{!! trans('messages.client_tips_written') !!}</p>
			</div>
		</div>
		<div class="progress-item-container col-xs-2">
			<div class="progress-item">
				<div class="circle">
					<span>{! reports.student.week_hours!}</span>
				</div>
				<p>{!! trans('messages.client_hours_spent_7_days') !!}</p>
			</div>
		</div>
		<div class="progress-item-container col-xs-2">
			<div class="progress-item">
				<div class="circle">
					<span>{! reports.student.total_hours!}</span>
				</div>
				<p>{!! trans('messages.client_hours_spent') !!}</p>
			</div>
		</div>
	</div>
</div>