<div class="container search-container" ng-if="answer.active_view || answer.active_edit">
	<div class="title-mid">
		<span>Help Answer Details</span>		
	</div>

	<div class="col-xs-12 success-container" ng-if="answer.errors || answer.success">
		<div class="alert alert-error" ng-if="answer.errors">
            <p ng-repeat="error in answer.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="answer.success">
            <p>{! answer.success !}</p>
        </div>
    </div>

    <div class="module-container">
    	{!! Form::open(
			array(
				'id' => 'tip_detail_form'
				, 'class' => 'form-horizontal'
			)
		) !!}
		<div class="form-group">
			<label class="control-label col-xs-3">Date Created</label>
			<div class="col-xs-5">
				<input type="text" ng-disabled="true" name="created_at" class="form-control" placeholder="Date Created" value="{! answer.record.created_at | ddMMyy !}" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-3">Title <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('search_name', ''
					, array(
						'ng-disabled'=>'answer.active_view'
						, 'class' => 'form-control'
						, 'ng-model' => 'answer.record.title'
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
						'ng-disabled'=>'answer.active_view'
						, 'class' => 'form-control disabled-textarea'
						, 'ng-model' => 'answer.record.content'
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
						, 'ng-model' => 'answer.record.created_by'
						, 'placeholder' => '>Created By'
					)
				) !!}
			</div>
		</div>
		<div class="btn-container" ng-if="answer.active_view && answer.record.tip_status == futureed.PENDING">
			<div class="col-xs-7 col-xs-offset-2">
				{!! Form::button('Approve'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "answer.updateStatus(answer.record.id, futureed.TRUE)"
					)
				) !!}
				{!! Form::button('Reject'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "answer.updateStatus(answer.record.id, futureed.FALSE)"
					)
				) !!}
			</div>
		</div>
		<div class="btn-container" ng-if="answer.active_view">
			<div class="col-xs-7 col-xs-offset-2">
				{!! Form::button('Edit'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "answer.setActive(futureed.ACTIVE_EDIT, answer.record.id)"
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "answer.setActive(futureed.ACTIVE_LIST)"
					)
				) !!}
			</div>
		</div>
		<div class="btn-container" ng-if="answer.active_edit">
			<div class="col-xs-7 col-xs-offset-2">
				{!! Form::button('Save'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "answer.update()"
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "answer.setActive(futureed.ACTIVE_VIEW, answer.record.id)"
					)
				) !!}
			</div>
		</div>
		{!! Form::close() !!}
    </div>
</div>