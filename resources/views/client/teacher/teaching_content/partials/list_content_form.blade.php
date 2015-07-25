<div class="container search-container" ng-if="content.active_list">
	<div class="title-mid">
		<span>Teaching Content</span>		
	</div>
	<div class="col-xs-12 content-container">
		<div class="row content-display">
			<div class="content-text" ng-show="content.details.media_type_id == futureed.TEXT">
				<p>{! content.details.content_text !}</p>
			</div>
			<div class="content-image" id="content-image" ng-if="content.details.media_type_id == futureed.IMAGE">
				
			</div>
			<div class="content-video" ng-show="content.details.media_type_id == futureed.VIDEO">
				<p>{! content.details.content_url !}</p>
			</div>
		</div>
	</div>
	<div class="col-xs-12 btn-content">
		<div class="col-xs-4">
			<button class="btn btn-gold btn-medium" ng-click="content.showContent(content.details.key, futureed.BACK)" ng-if="content.details.key != futureed.FALSE">Back</button>
		</div>
		<div class="col-xs-4">
			<center><h2 class="title-content">{! content.details.teaching_module !}</h2></center>
		</div>
		<div class="col-xs-4">
			<button class="btn btn-maroon btn-medium pull-right" ng-click="content.showContent(content.details.key, futureed.NEXT)" ng-if="content.details.key != content.total">Next</button>
		</div>
	</div>
	<div class="col-xs-12 content-list">
		<div ng-repeat="record in content.records" class="col-xs-4" ng-show="record.key != content.details.key">
			<a href="#" class="btn btn-blue content-btn" ng-click="content.showContent(record.key)">{! record.teaching_module !}</a>
		</div>
	</div>
</div>