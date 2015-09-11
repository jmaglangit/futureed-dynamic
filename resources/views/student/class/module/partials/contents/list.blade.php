<div class="contents-container col-xs-12" ng-if="mod.contents.teaching_content.media_type.id == futureed.VIDEO">
	<!-- TODO: Mar -->
	<iframe ng-if="mod.contents.teaching_content.content_url" ng-src="{! mod.contents.teaching_content.content_url | trustAsResourceUrl !}" width="100%" height="500" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ng-cloak></iframe>

	<div>
		{!! Form::button('Exit Module'
			,array(
				'class' => 'btn btn-maroon exit-btn'
				, 'ng-click' => "mod.exitModule()"
			)
		)!!}
		{!! Form::button('Skip'
			,array(
				'class' => 'btn btn-gold next-btn'
				, 'ng-click' => 'mod.startQuestions()'
			)
		)!!}
	</div>

	<div class="content-pagination" ng-if="mod.record">
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
</div>

<div ng-if="mod.contents.teaching_content.media_type.id == futureed.IMAGE">
	<div class="questions-container col-xs-12">
		<div class="questions-header">
			<h3> {! mod.contents.teaching_content.teaching_module !} </h3>
		</div>

		<div class="content-body">
			<div class="questions-image">
				<img ng-if="mod.current_question.original_image_name" ng-src="{! mod.current_question.questions_image !}" />
			</div>

			<div class="questions-message">
				<p ng-bind-html="mod.contents.teaching_content.content_text | trustAsHtml"></p>
			</div>
		</div>

		<div class="content-pagination" ng-if="mod.record">
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
			{!! Form::button('Exit Module'
				,array(
					'class' => 'btn btn-gold exit-btn'
					, 'ng-click' => "mod.exitModule()"
				)
			)!!}
			{!! Form::button('Skip'
				,array(
					'class' => 'btn btn-maroon next-btn'
					, 'ng-click' => 'mod.startQuestions()'
				)
			)!!}
		</div>
	</div>
</div>

<div ng-if="mod.contents.teaching_content.media_type.id == futureed.TEXT">
	<div class="questions-container col-xs-12">
		<div class="questions-header">
			<h3> {! mod.contents.teaching_content.teaching_module !} </h3>
		</div>

		<div class="content-body">
			<div class="questions-image">
				<img ng-if="mod.current_question.original_image_name" ng-src="{! mod.current_question.questions_image !}" />
			</div>

			<div class="questions-message">
				<p ng-bind-html="mod.contents.teaching_content.content_text | trustAsHtml"></p>
			</div>
		</div>

		<div class="content-pagination" ng-if="mod.record">
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
			{!! Form::button('Exit Module'
				,array(
					'class' => 'btn btn-gold exit-btn'
					, 'ng-click' => "mod.exitModule()"
				)
			)!!}
			{!! Form::button('Skip'
				,array(
					'class' => 'btn btn-maroon next-btn'
					, 'ng-click' => 'mod.startQuestions()'
				)
			)!!}
		</div>
	</div>
</div>