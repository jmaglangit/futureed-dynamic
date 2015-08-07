<div class="col-xs-12 margin-top-15" ng-if="help.active_view">
	<div class="view-help-container">
		<div class="content-box row margin-top-bot-5">
			<div>
				<div class="row">
					<div class="col-xs-6">
						<p class="tip-title">{! help.record.title !}</p class="title-mid">
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						<p><i class="fa fa-calendar-o"></i> {! help.record.created_at !}</p>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6" ng-if="help.record.subject_area_name && help.record.subject_name">
						<p>{! help.record.subject_area_name !} > {! help.record.subject_name !}</p>
					</div>
					<div class="col-xs-6">
						<span><i class="fa fa-user"></i> By : {! help.record.name !}</span>
					</div>
				</div>

				<div class="row">
					<hr/>
					<p>{! help.record.content !}</p>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="help-container" ng-repeat="rec in help.ans_record">
				<div class="row">
					<h4>{! rec.content !}</h4>
				</div>
				<div class="row">
					<div class="col-xs-6 pull-right">
						<span><i class="fa fa-user"></i> {! rec.student.first_name !} {! rec.student.last_name !}</span>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 pull-right">
						<span ng-repeat="i in help.record.stars track by $index">
							<!-- <img ng-if="!answer.rating" ng-mouseover="help.changeColor($index, answer.id)" ng-src="{! (help.hovered[answer.id][$index])  && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" /> -->
							<!-- <img ng-if="answer.rating" ng-src="{! $index + 1 <= answer.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" /> -->
							<img ng-src="{! $index+1 <= rec.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="btn-container">
		<button type="button" class="btn btn-gold btn-medium pull-right"
			ng-click="help.setActive()"> Back </button>
	</div>
</div>