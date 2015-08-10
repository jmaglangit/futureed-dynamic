<div class="container search-container" ng-if="content.active_list">
	<div class="title-mid">
		<span>Teaching Content</span>
		<div class="pull-right col-xs-4" ng-if="!content.no_content">
			<a class="btn btn-medium btn-maroon pull-right" href="{!! route('client.parent.question.index') !!}">Skip</a>	
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
			<div class="content-text" ng-show="content.content.media_type_id == futureed.TEXT">
				<p>{! content.content.content_text !}</p>
			</div>
			<div class="image-container" id="content-image" ng-if="content.content.media_type_id == futureed.IMAGE">
				<img class="content-image" ng-src="{! content.content.content_url !}">
			</div>
			<div class="content-video" ng-show="content.content.media_type_id == futureed.VIDEO" ng-cloak>
				<iframe ng-if="content.content.content_url" ng-src="{! content.content.content_url | trustAsResourceUrl !}" width="100%" height="500" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ng-cloak></iframe>
			</div>
		</div>
	</div>
	<div class="col-xs-12 btn-content" ng-if="!content.no_content">
		<div class="col-xs-4">
			<button class="btn btn-gold btn-medium" ng-click="content.navigate(content.detail.key, futureed.BACK)" ng-if="content.detail.key != futureed.FALSE">Previous</button>
		</div>
		<div class="col-xs-4">
			<center><h2 class="title-content">{! content.content.teaching_module !}</h2></center>
		</div>
		<div class="col-xs-4">
			<button class="btn btn-maroon btn-medium pull-right" ng-click="content.navigate(content.detail.key, futureed.NEXT)" ng-if="content.detail.key != content.total">Next</button>
		</div>
	</div>
	<div class="col-xs-12 content-list">
		<div ng-repeat="record in content.records track by $index" class="col-xs-4">
			<a href="javascript:;" class="btn btn-blue content-btn" id="content_name" ng-click="content.getContent(record.id, $index)">{! record.teaching_module !}</a>
		</div>
	</div>
</div>