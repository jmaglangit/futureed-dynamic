<div class="col-xs-10 col-xs-offset-1 margin-top-15" ng-if="mod.active_help_add">
	<div class="alert alert-error" ng-if="mod.errors">
        <p ng-repeat="error in mod.errors track by $index" > 
            {! error !}
        </p>
    </div>
    <div class="alert alert-success" ng-if="mod.success">
    	<p>Successfully added your help request</p>
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
					    , 'ng-model' => 'mod.add.title'
					    , 'autocomplete' => 'off')
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Description</label>
			<div class="col-xs-10">
				{!! Form::textarea('content', ''
					, array(
					    'class' => 'form-control sidebar-input'
					    , 'placeholder' => 'Description' 
					    , 'ng-model' => 'mod.add.content'
					    , 'autocomplete' => 'off')
				) !!}
			</div>
		</div>
	</div>
	<div class="col-xs-12 btn-container">
		{!! Form::button('Submit'
			, array(
			  'id' => 'validate_code_btn'
			  , 'class' => 'btn btn-maroon btn-medium'
			  , 'ng-click' => 'mod.addHelp()'
			)
		) !!}
        {!! Form::button('Back'
            , array(
              'id' => 'validate_code_btn'
              , 'class' => 'btn btn-gold btn-medium'
              , 'ng-click' => 'mod.setCurrentActive(); mod.toggleBtnHelp()'
            )
        ) !!}
	</div>
</div>