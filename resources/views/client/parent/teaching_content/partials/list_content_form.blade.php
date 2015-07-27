<div class="container search-container" ng-if="content.active_list">
	<div class="title-mid">
		<span>Teaching Content</span>
		<div class="pull-right col-xs-4" ng-if="!content.no_content">
			<a class="btn btn-medium btn-maroon pull-right">Skip</a>	
		</div>
		<div class="pull-right col-xs-4" ng-if="content.no_content">
			<a class="btn btn-medium btn-gold pull-right" href="{!! route('client.parent.module.index') !!}">Back</a>	
		</div>	
	</div>
	<div class="col-xs-12 content-container" ng-if="content.no_content">
		<div class="alert alert-info margin-top-60">
			<center><span><i class="fa fa-info-circle"></i> No Content Available</span></center>
		</div>
	</div>
	<div class="col-xs-12 content-container" ng-if="!content.no_content">
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
	<div class="col-xs-12 btn-content" ng-if="!content.no_content">
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