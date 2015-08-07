<div class="col-xs-12 margin-top-15" ng-if="help.active_add">
	<div id="help_request_list" class="view-help-container">
		<div class="alert alert-error" ng-if="help.errors">
	        <p ng-repeat="error in help.errors track by $index" > 
	            {! error !}
	        </p>
	    </div>
	    <div class="alert alert-success" ng-if="help.success">
	    	<p>Successfully added your help request. </p>
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
						    , 'ng-model' => 'help.record.title'
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
		                    , 'ng-model' => 'help.record.content'
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
			  , 'ng-click' => 'help.addHelp()'
			)
		) !!}

		{!! Form::button('Back'
			, array(
				 'class' => 'btn btn-gold btn-medium'
				, 'ng-click' => 'help.setActive()'
				)
		) !!}
	</div>
	{!! Form::close() !!}
</div>