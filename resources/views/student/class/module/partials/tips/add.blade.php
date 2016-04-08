<div class="col-xs-12 margin-top-15" ng-if="tips.active_add">
	<div id="add_tip" class="view-tips-container">
		<div class="alert alert-error" ng-if="tips.errors">
	        <p ng-repeat="error in tips.errors track by $index" > 
	            {! error !}
	        </p>
	    </div>
	    <div class="alert alert-success" ng-if="tips.success">
	    	<p>{!! trans('messages.successful_add_tip') !!}</p>
	    </div>

		<div class="col-xs-12">
			<div class="clearfix"></div>
			{!! Form::open(['class' => 'form-horizontal margin-top-15']) !!}
			<div class="form-group">
				<label class="control-label col-xs-2">{!! trans('messages.title') !!}</label>
				<div class="col-xs-10">
					{!! Form::text('title', ''
						, array(
						    'class' => 'form-control sidebar-input'
						    , 'placeholder' => trans('messages.title')
						    , 'ng-model' => 'tips.record.title'
						    , 'autocomplete' => 'off')
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-2">{!! trans('messages.description') !!}</label>
				<div class="col-xs-10">
					{!! Form::textarea('content', ''
		                , array(
		                    'class' => 'form-control sidebar-input disabled-textarea'
		                    , 'placeholder' => trans('messages.description')
		                    , 'ng-model' => 'tips.record.content'
		                    , 'autocomplete' => 'off')
		            ) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-10 col-xs-offset-2 btn-container">
		{!! Form::button(trans('messages.submit')
			, array(
			  'id' => 'validate_code_btn'
			  , 'class' => 'btn btn-maroon btn-medium'
			  , 'ng-click' => 'tips.add()'
			)
		) !!}

		{!! Form::button(trans('messages.back')
			, array(
				 'class' => 'btn btn-gold btn-medium'
				, 'ng-click' => 'tips.viewTipList()'
				)
		) !!}
	</div>
	{!! Form::close() !!}
</div>