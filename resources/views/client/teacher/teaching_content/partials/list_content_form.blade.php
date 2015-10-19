<div class="col-xs-12 teacher-module-container" ng-if="content.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span><i class="fa fa-lightbulb-o"></i> Teaching Content </span>

			<div class="col-xs-2 pull-right">
				<span>
					<a href="{!! route('client.teacher.module.index') !!}" class="btn btn-gold teacher-module-back">Back</a>
				</span>
			</div>
		</div>
	</div>

	<div class="teacher-module-btn">
		<button class="btn btn-maroon" ng-click="content.viewQuestions('{!! route('client.teacher.question.index') !!}')">View Questions</button> 
	</div>

	<div class="no-content-container col-xs-12" ng-if="!content.content">
		<div class="alert alert-info">
			<center><span><i class="fa fa-info-circle"></i> No Content Available</span></center>
		</div>
	</div>

	<div class="content-container col-xs-12" ng-if="content.content">
		<div class="content-header">
			<h3> {! content.content.teaching_module !} </h3>
		</div>

		<div class="content-body">
			<div class="content-message" ng-if="content.content.media_type_id == futureed.TEXT">
				<p ng-bind-html="content.content.content_text | trustAsHtml"></p>
			</div>

			<div class="content-image" ng-if="content.content.media_type_id == futureed.IMAGE">
				<img ng-if="content.content.content_url" ng-src="{! content.content.content_url !}" />
			</div>

			<div class="content-video" ng-if="content.content.media_type.id == futureed.VIDEO">
				<iframe ng-if="content.content.content_url" ng-src="{! content.content.content_url | trustAsResourceUrl !}" width="100%" height="500" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ng-cloak></iframe>
			</div>
		</div>
	</div>

	<div class="content-pagination" ng-if="content.content">
		<pagination 
			total-items="content.table.total_items" 
			ng-model="content.table.page"
			max-size="1"
			items-per-page="content.table.size" 
			previous-text = "&lt;"
			next-text="&gt;"
			class="pagination" 
			boundary-links="true"
			ng-change="content.paginateByPage()">
		</pagination>
	</div>

	<div class="col-xs-12 teacher-content-list" ng-if="content.content">
		<div class="teacher-module-btn" ng-init="content.selectAllContents()">
			<button ng-repeat="record in content.records track by $index" class="btn btn-blue" ng-click="content.getContent(record.id, $index)">{! record.teaching_module !}</button>
		</div>
	</div>
</div>