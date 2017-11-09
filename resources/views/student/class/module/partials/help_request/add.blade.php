<div class="col-xs-12 margin-top-15" ng-if="help.active_add">
	<div id="help_request_list" class="view-help-container">
		<div class="alert alert-error" ng-if="help.errors">
	        <p ng-repeat="error in help.errors track by $index" > 
	            {! error !}
	        </p>
	    </div>
	    <div class="alert alert-success" ng-if="help.success">
	    	<p>{!! trans('messages.successful_add_help_request_2') !!} </p>
	    </div>

		<div class="col-xs-12">
			<div class="clearfix"></div>
			<div class="form-horizontal margin-top-15 add_help_form">
				<div class="form-group">
					<label class="control-label col-xs-2">{{ trans('messages.title') }}</label>
					<div class="col-xs-10">
						{!! Form::text('title', ''
							, array(
								'class' => 'form-control sidebar-input'
								, 'placeholder' => trans('messages.title')
								, 'ng-model' => 'help.record.title'
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
								, 'ng-model' => 'help.record.content'
								, 'autocomplete' => 'off')
						) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-10 col-xs-offset-2 btn-container">
		{!! Form::button(trans('messages.submit')
			, array(
			  'id' => 'validate_code_btn'
			  , 'class' => 'btn btn-green btn-medium'
			  , 'ng-click' => 'help.addHelp()'
			)
		) !!}

		{!! Form::button(trans('messages.back')
			, array(
				 'class' => 'btn btn-gold btn-medium'
				, 'ng-click' => 'help.viewHelpList();'
				)
		) !!}
	</div>
</div>