<div ng-if="student.active_edit_reward">
	<div class="content-title">
		<div class="title-main-content" ng-show="student.active_points">
			<span>{!! trans('messages.admin_edit_points') !!}</span>
		</div>
		<div class="title-main-content" ng-show="student.active_badge">
			<span>{!! trans('messages.admin_edit_badges') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="student.errors || student.success">
        <div class="alert alert-error" ng-if="student.errors">
            <p ng-repeat="error in student.errors track by $index">
                {! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="student.success">
            <p>{! student.success !}</p>
        </div>
    </div>

    {!! Form::open(array('class' => 'form-horizontal')) !!}
    <div class="col-xs-12 form-content" ng-if="student.active_points">
    	<fieldset>
    		<div class="form-group">
    			<label class="control-label col-xs-3">{!! trans('messages.points') !!} <span class="required">*</span></label>
                <div class="col-xs-5">
                    {!! Form::text('points',''
                        , array(
                            'placeHolder' => trans('messages.points')
                            , 'ng-model' => 'student.point_detail.points_earned'
                            , 'class' => 'form-control'
                        )
                    ) !!}
                </div>
    		</div>
    		<div class="form-group">
        		<label class="col-md-3 control-label">{!! trans('messages.admin_event') !!} <span class="required">*</span></label>
        		<div class="col-md-5">
        			{!! Form::text('event',''
        				, array(
        					'placeHolder' => trans('messages.admin_event')
        					, 'ng-model' => 'student.point_detail.event'
        					, 'ng-change' => "student.getEvents(student.point_detail.event)"
        					, 'ng-class' => "{ 'required-field' : student.fields['event'] }"
                    		, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
        					, 'class' => 'form-control'
        				)
        			) !!}
        			<div class="angucomplete-holder" ng-if="student.events">
						<ul class="col-md-6 angucomplete-dropdown">
							<li class="angucomplete-row" ng-repeat="event in student.events" ng-click="student.selectEvent(event)">
								{! event.name !}
							</li>
						</ul>
					</div>
        		</div>
        		<div class="margin-top-8"> 
	                <i ng-if="student.s_loading" class="fa fa-spinner fa-spin"></i>
	                <span ng-if="student.s_error" class="error-msg-con">{! student.s_error !}</span>
	            </div>
        	</div>
        	<div class="form-group">
                <label class="control-label col-xs-3">{!! trans('messages.description') !!}</label>
                <div class="col-xs-5">
                    {!! Form::text('description',''
                        , array(
                            'placeHolder' => trans('messages.description')
                            , 'ng-disabled' => 'true'
                            , 'ng-model' => 'student.point_detail.description'
                            , 'class' => 'form-control'
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">{!! trans('messages.admin_date_earned') !!}</label>
                <div class="col-xs-5">
                    {!! Form::text('date_earned',''
                        , array(
                            'placeHolder' => trans('messages.admin_date_earned')
                            , 'ng-disabled' => 'true'
                            , 'ng-model' => 'student.point_detail.date_earned'
                            , 'class' => 'form-control'
                        )
                    ) !!}
                </div>
            </div>
    	</fieldset>
    	<div class="btn-container col-md-9 col-md-offset-1">
	        	{!! Form::button(trans('messages.save')
	        		, array(
	        			'class' => 'btn btn-blue btn-medium'
	        			, 'ng-click' => 'student.savePoint()'
	        		)
	        	) !!}

	        	{!! Form::button(trans('messages.cancel')
	        		, array(
	        			'class' => 'btn btn-gold btn-medium'
	        			, 'ng-click' => "student.setActive('reward', student.record.id)"
	        		)
	        	) !!}
		     </div>
    </div>
    <div class="col-xs-12 form-content" ng-if="student.active_badge">
    	<fieldset>
    		<div class="form-group">
        		<label class="col-md-3 control-label">{!! trans('messages.badge') !!} <span class="required">*</span></label>
        		<div class="col-md-5">
        			{!! Form::text('badge',''
        				, array(
        					'placeHolder' => trans('messages.badge')
        					, 'ng-model' => 'student.badge_detail.name'
        					, 'ng-change' => "student.getAllBadges(student.badge_detail.name)"
        					, 'ng-class' => "{ 'required-field' : student.fields['name'] }"
                    		, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
        					, 'class' => 'form-control'
        				)
        			) !!}
        			<div class="angucomplete-holder" ng-if="student.list_badges">
						<ul class="col-md-6 angucomplete-dropdown">
							<li class="angucomplete-row" ng-repeat="badge in student.list_badges" ng-click="student.selectBadge(badge)">
								{! badge.name !}
							</li>
						</ul>
					</div>
        		</div>
        		<div class="margin-top-8"> 
	                <i ng-if="student.s_loading" class="fa fa-spinner fa-spin"></i>
	                <span ng-if="student.s_error" class="error-msg-con">{! student.s_error !}</span>
	            </div>
        	</div>
            <div class="form-group">
                <label class="control-label col-xs-3">{!! trans('messages.admin_date_earned') !!}</label>
                <div class="col-xs-5">
                    {!! Form::text('date_earned',''
                        , array(
                            'placeHolder' => trans('messages.admin_date_earned')
                            , 'ng-disabled' => 'true'
                            , 'ng-model' => 'student.point_detail.date_earned'
                            , 'class' => 'form-control'
                        )
                    ) !!}
                </div>
            </div>
    	</fieldset>
    	<div class="btn-container col-md-9 col-md-offset-1">
	        	{!! Form::button(trans('messages.save')
	        		, array(
	        			'class' => 'btn btn-blue btn-medium'
	        			, 'ng-click' => 'student.saveBadge()'
	        		)
	        	) !!}

	        	{!! Form::button(trans('messages.cancel')
	        		, array(
	        			'class' => 'btn btn-gold btn-medium'
	        			, 'ng-click' => "student.setActive('reward', student.record.id)"
	        		)
	        	) !!}
		     </div>
    </div>
</div>
<div id="delete_badge_modal" ng-show="student.delete.confirm_badge" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            {!! trans('messages.admin_delete_badge') !!}
        </div>
        <div class="modal-body">
            {!! trans('messages.admin_delete_badge_msg') !!}
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button(trans('messages.yes')
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => 'student.deleteBadge()'
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}

                {!! Form::button(trans('messages.no')
                    , array(
                        'class' => 'btn btn-gold btn-medium'
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}
        	</div>
        </div>
    </div>
  </div>
</div>