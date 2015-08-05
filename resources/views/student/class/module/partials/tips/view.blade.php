<div class="col-xs-12 margin-top-15" ng-if="tips.active_view">
	<div class="view-tips-container">
		<div class="content-box row margin-top-bot-5">
			<div class="help-container">
				<div class="row">
					<div class="col-xs-6">
						<p class="tip-title">{! tips.record.title !}</p class="title-mid">
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						<p><i class="fa fa-calendar-o"></i> {! tips.record.created_at !}</p>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						<p>{! tips.record.subject_area_name !} > {! tips.record.subject_name !}</p>
					</div>
					<div class="col-xs-6">
						<span><i class="fa fa-user"></i> By : {! tips.record.name !}</span>
					</div>
				</div>

				<div class="row">
					<hr/>
					<p>{! tips.record.content !}</p>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="help-container" ng-repeat="rec in tips.ans_record">
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
						<span ng-repeat="i in tips.record.stars track by $index">
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
			ng-click="tips.viewTipList()"> Back </button>
	</div>
</div>