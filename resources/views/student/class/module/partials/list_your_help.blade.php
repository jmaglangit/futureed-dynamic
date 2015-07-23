<div class="col-xs-12 margin-top-15 list-container" ng-if="mod.active_own_list">
	<div class="content-box row margin-top-bot-5" ng-if="mod.own_records.length == 0">
		<center><h2>No Help Request Found</h2></center>
	</div>
	<div class="content-box row margin-top-bot-5" ng-repeat="own in mod.own_records">
		<a href="#" ng-click="mod.setOwnActive('view', own.id)"><h4 class="list-title">{! own.title !}</h4></a>
		<div class="row">
			<div class="col-xs-6">
				<span><i class="fa fa-user"></i> {! own.student.first_name !} {! own.student.last_name !}</span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<span><i class="fa fa-tag"></i> {! own.module.description !} > {! own.module.common_core_area !}</span>
			</div>
			<div class="col-xs-6">
				<span><i class="fa fa-tag"></i> {! own.created_at !}</span>
			</div>
		</div>
	</div>
</div>