<div class="col-xs-12 margin-top-15 list-container" ng-if="mod.active_current_tip_list">
	<div class="content-box" ng-if="mod.tip_records.length == 0">
		<center><h2>No Tips Found</h2></center>
	</div>
	<div class="content-box" ng-repeat="current in mod.tip_records">
		<div class="row content-row">
			<div class="col-xs-6">
				<span class="content-bar-title" ng-click="mod.setCurrentActiveTip('view', current.id)">
					{! current.title !}
				</span>
			</div>
		</div>
		<div class="row content-row">
			<div class="col-xs-6">
				<span><i class="fa fa-user"></i> {! current.student.first_name !} {! current.student.last_name !}</span>
			</div>
			<div class="col-xs-6">
				<span ng-repeat="i in current.stars track by $index">
					<img ng-class="{ 'unrated-star' : $index + 1 > current.rating || !tip_record.rating}" 
						ng-src="{! $index + 1 <= current.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
				</span>
			</div>
		</div>
		<div class="row content-row">
			<div class="col-xs-6">
				<span><i class="fa fa-tag"></i> {! current.module.description !} {! current.module.common_core_area !}</span>
			</div>
			<div class="col-xs-6">
				<span><i class="fa fa-calendar-o"></i> {! current.created_at !}</span>
			</div>
		</div>
	</div>

	<div class="col-xs-8" ng-if="mod.show_btn">
		<button class="btn btn-maroon" ng-click="mod.tipList('', futureed.CURRENT, 1)">View More</button>
	</div>
</div>