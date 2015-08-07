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
					<div class="col-xs-6" ng-if="tips.record.subject_area_name && tips.record.subject_name">
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
		</div>
	</div>
	<div class="btn-container">
		<button type="button" class="btn btn-gold btn-medium pull-right"
			ng-click="tips.viewTipList()"> Back </button>
	</div>
</div>