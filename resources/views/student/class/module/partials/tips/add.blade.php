<div class="col-xs-12 margin-top-15" ng-if="tips.active_add">
	<div id="add_tip" class="view-tips-container">
		<div class="alert alert-error" ng-if="tips.errors">
	        <p ng-repeat="error in tips.errors track by $index" > 
	            {! error !}
	        </p>
	    </div>
	    <div class="alert alert-success" ng-if="tips.success">
	    	<p>Successfully added your tip. </p>
	    </div>

		<div class="col-xs-12">
			<div class="clearfix"></div>
			{!! Form::open(['class' => 'form-horizontal margin-top-15']) !!}
			<div class="form-group">
				<label class="control-label col-xs-2">Title</label>
				<div class="col-xs-10">
					{!! Form::text('title', ''
						, array(
						    'class' => 'form-control sidebar-input'
						    , 'placeholder' => 'Title' 
						    , 'ng-model' => 'tips.record.title'
						    , 'autocomplete' => 'off')
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-2">Description</label>
				<div class="col-xs-10">
					{!! Form::textarea('content', ''
		                , array(
		                    'class' => 'form-control sidebar-input disabled-textarea'
		                    , 'placeholder' => 'Description' 
		                    , 'ng-model' => 'tips.record.content'
		                    , 'autocomplete' => 'off')
		            ) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-10 col-xs-offset-2 btn-container">
		{!! Form::button('Submit'
			, array(
			  'id' => 'validate_code_btn'
			  , 'class' => 'btn btn-maroon btn-medium'
			  , 'ng-click' => 'tips.add()'
			)
		) !!}

		{!! Form::button('Back'
			, array(
				 'class' => 'btn btn-gold btn-medium'
				, 'ng-click' => 'tips.viewTipList()'
				)
		) !!}
	</div>
	{!! Form::close() !!}
</div>