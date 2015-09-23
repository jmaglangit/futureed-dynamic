
<div class="col-xs-12">
	<div ng-if="mod.contents.teaching_content.media_type.id == futureed.VIDEO">
		<iframe ng-if="mod.contents.teaching_content.content_url" ng-src="{! mod.contents.teaching_content.content_url | trustAsResourceUrl !}" width="100%" height="450" frameborder="2" webkitallowfullscreen mozallowfullscreen allowfullscreen ng-cloak></iframe>
	</div>

	<div ng-if="mod.contents.teaching_content.media_type.id == futureed.IMAGE">
		<div class="content-container col-xs-12">
			<div class="content-header">
				<h3> {! mod.contents.teaching_content.teaching_module !} </h3>
			</div>

			<div class="content-body">
				<div class="content-image">
					<img ng-if="mod.contents.teaching_content.original_image_name" ng-src="{! mod.contents.teaching_content.content_url !}" />
				</div>
			</div>
		</div>
	</div>

	<div ng-if="mod.contents.teaching_content.media_type.id == futureed.TEXT">
		<div class="content-container col-xs-12">
			<div class="content-header">
				<h3> {! mod.contents.teaching_content.teaching_module !} </h3>
			</div>

			<div class="content-body">
				<div class="content-message">
					<p ng-bind-html="mod.contents.teaching_content.content_text | trustAsHtml"></p>
				</div>
			</div>
		</div>
	</div>

	<div ng-if="!mod.contents.teaching_content">
		<div class="content-container col-xs-12">
			<div class="content-header">
				<h3>Content</h3>
			</div>

			<div class="content-body">
				<div class="content-message">
					<h3 class="alert alert-info">Content not available. </h3>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content-pagination" ng-if="mod.contents">
	<pagination 
		total-items="mod.table.total_items" 
		ng-model="mod.table.page"
		max-size="1"
		items-per-page="mod.table.size" 
		previous-text = "Prev"
		next-text="Next"
		class="pagination" 
		ng-change="mod.paginateContent()">
	</pagination>
</div>

<div>
	<button type="button" class="btn btn-maroon exit-btn" ng-click="mod.exitModule('{!! route('student.class.index') !!}')">Exit Module</button>
	{!! Form::button('Skip'
		,array(
			'class' => 'btn btn-gold next-btn'
			, 'ng-click' => 'mod.startQuestions()'
			, 'ng-if' => "mod.record.student_module.module_status == 'On Going'"
		)
	)!!}
</div>