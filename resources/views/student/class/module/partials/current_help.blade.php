<div class="col-xs-12 margin-top-15 list-container" ng-if="mod.active_current_list">
	<div class="content-box row margin-top-bot-5" ng-if="mod.records.length == 0">
		<center><h2>No Help Request Found</h2></center>
	</div>
	<div class="content-box row margin-top-bot-5" ng-repeat="current in mod.records">
		<a href="#" ng-click="mod.setCurrentActive('view', current.id)"><h4 class="list-title">{! current.title !}</h4></a>
		<div class="row">
			<div class="col-xs-6">
				<span><i class="fa fa-user"></i> {! current.student.first_name !} {! current.student.last_name !}</span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<span><i class="fa fa-tag"></i> {! current.module.description !} > {! current.module.common_core_area !}</span>
			</div>
			<div class="col-xs-6">
				<span><i class="fa fa-tag"></i> {! current.created_at !}</span>
			</div>
		</div>
	</div>
</div>