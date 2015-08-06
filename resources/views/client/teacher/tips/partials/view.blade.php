<div class="container search-container" ng-if="tips.active_view || tips.active_edit">
	<div class="title-mid">
		<span>Tip Details</span>		
	</div>

	<div class="col-xs-12 success-container" ng-if="tips.errors || tips.success">
		<div class="alert alert-error" ng-if="tips.errors">
            <p ng-repeat="error in tips.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="tips.success">
            <p>{! tips.success !}</p>
        </div>
    </div>

    <div class="module-container">
    	{!! Form::open(
			array(
				'id' => 'tip_detail_form'
				, 'class' => 'form-horizontal'
			)
		) !!}
		<div class="form-group" ng-if="tips.record.link_type != futureed.General && tips.record.subject">
			<label class="control-label col-xs-3">Subject</label>
			<div class="col-xs-5">
				{!! Form::text('subject', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.record.subject'
						, 'placeholder' => 'Subject'
					)
				) !!}
			</div>
		</div>
		<div class="form-group" ng-if="tips.record.link_type != futureed.General && tips.record.subject_area">
			<label class="control-label col-xs-3">Subject Area</label>
			<div class="col-xs-5">
				{!! Form::text('subject_area', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.record.subject_area'
						, 'placeholder' => 'Subject Area'
					)
				) !!}
			</div>
		</div>
		<div class="form-group" ng-if="tips.record.link_type != futureed.General && tips.record.module">
			<label class="control-label col-xs-3">Module</label>
			<div class="col-xs-5">
				{!! Form::text('module', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.record.module'
						, 'placeholder' => 'Module'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-3">Date Created</label>
			<div class="col-xs-5">
				<input type="text" ng-disabled="true" name="created_at" class="form-control" placeholder="Date Created" value="{! tips.record.created_at | ddMMyyHHmmss : '-' !}" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-3">Title <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('search_name', ''
					, array(
						'ng-disabled'=>'tips.active_view'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.record.title'
						, 'placeholder' => 'Title'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-3">Description <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::textarea('search_name', ''
					, array(
						'ng-disabled'=>'tips.active_view'
						, 'class' => 'form-control disabled-textarea'
						, 'ng-model' => 'tips.record.content'
						, 'placeholder' => 'Description'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-3">Created By</span></label>
			<div class="col-xs-5">
				{!! Form::text('search_name', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.record.created_by'
						, 'placeholder' => 'Created By'
					)
				) !!}
			</div>
		</div>
		<div class="btn-container" ng-if="tips.active_view && tips.record.tip_status == futureed.PENDING">
			<div class="col-xs-7 col-xs-offset-2">
				{!! Form::button('Approve'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "tips.rateTip()"
					)
				) !!}
				{!! Form::button('Reject'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "tips.updateStatus(tips.record.id, futureed.FALSE)"
					)
				) !!}
			</div>
		</div>
		<div class="btn-container" ng-if="tips.active_view">
			<div class="col-xs-7 col-xs-offset-2">
				{!! Form::button('Edit'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "tips.setActive(futureed.ACTIVE_EDIT, tips.record.id)"
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "tips.setActive(futureed.ACTIVE_LIST)"
					)
				) !!}
			</div>
		</div>
		<div class="btn-container" ng-if="tips.active_edit">
			<div class="col-xs-7 col-xs-offset-2">
				{!! Form::button('Save'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "tips.update()"
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "tips.setActive(futureed.ACTIVE_VIEW, tips.record.id)"
					)
				) !!}
			</div>
		</div>
		{!! Form::close() !!}
    </div>
</div>
<div id="rate_tip" ng-show="tips.rate_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myMediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    Rate this tip
                </div>
                <div class="modal-body">
	                <div class="alert alert-error" ng-if="tips.rate_errors">
			            <p ng-repeat="error in tips.rate_errors track by $index" > 
			              	{! error !}
			            </p>
			        </div>
                    {!! Form::select('rate'
						, array(
							'' => '-- Select Rate --'
							, '1' => '1'
							, '2' => '2'
							, '3' => '3'
							, '4' => '4'
							, '5' => '5'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'tips.rating'
						)
					) !!}
                </div>
                <div class="modal-footer">
                    <div class="btncon col-md-8 col-md-offset-4 pull-left">
                        {!! Form::button('Accept'
                            , array(
                                'class' => 'btn btn-blue btn-medium'
                                , 'ng-click' => 'tips.updateStatus(tips.record.id, futureed.TRUE)'
                            )
                        ) !!}
                        {!! Form::button('Cancel'
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