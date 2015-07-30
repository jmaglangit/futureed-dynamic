<div class="contents-container col-xs-8">

	<iframe ng-if="mod.active_contents" ng-src="{! mod.contents.content_url | trustAsResourceUrl !}" width="100%" height="500" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ng-cloak></iframe>

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