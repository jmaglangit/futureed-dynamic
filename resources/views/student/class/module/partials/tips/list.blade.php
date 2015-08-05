<div class="col-xs-12 margin-top-15" ng-if="tips.active_list">
	<div class="alert alert-error" ng-if="tips.errors">
		<p ng-repeat="error in tips.errors track by $index" > 
			{! error !}
		</p>
	</div>
	<div class="alert alert-success" ng-if="tips.success">
		<p>{! tips.success !}</p>
	</div>
    <div class="col-xs-12">
    	<ul class="nav nav-pills col-xs-12">
    		<li class="active">
    			<a class="pill-grey" href="#current" data-toggle="tab" ng-click="tips.setTipTabActive(futureed.CURRENT)">Current</a>
    		</li>
    		<li>
    			<a class="pill-grey" href="#" data-toggle="tab" ng-click="tips.setTipTabActive(futureed.ALL)">All</a>
    		</li>
    	</ul>

    	<div class="tab-content">
    		<div class="tab-pane active" id="current">
		    	<div class="tips-container">
					<div class="content-box" ng-if="!tips.records.length">
						<div class="row content-row">
							<center><p>No Tips Found</p></center>
						</div>
					</div>

					<div class="content-box" ng-repeat="current in tips.records">
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
		    </div>
    	</div>
    </div>
</div>