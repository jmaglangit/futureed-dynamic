<div class="clearfix"></div>
<div class="container search-container" ng-if="tips.help_active_view">
	<div class="title-mid">
		<span>View Help</span>		
	</div>
	<div class="col-xs-12 success-container" ng-if="tips.help_errors || tips.help_success">
		<div class="alert alert-error" ng-if="tips.help_errors">
            <p ng-repeat="error in tips.help_errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="tips.help_success">
            <p>{! tips.help_success !}</p>
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
			<label class="control-label col-xs-2">Subject</label>
			<div class="col-md-5">
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
		<div class="form-group">
			<label class="control-label col-xs-2">Subject Area</label>
			<div class="col-md-5">
				{!! Form::text('subject', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.record.subject_area'
						, 'placeholder' => 'Subject Area'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Module</label>
			<div class="col-md-5">
				{!! Form::text('subject', ''
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
			<label class="control-label col-xs-2">Date Created</label>
			<div class="col-md-5">
				{!! Form::text('search_name', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.help_record.created_at'
						, 'placeholder' => 'Date Created'
					)
				) !!}
			</div>
			<div class="col-xs-5">
				{!! Form::button('Approve'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "tips.updateHelp(tips.help_record.id, 1)"
						, 'ng-if' => '!tips.edit'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Title <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('search_name', ''
					, array(
						'ng-disabled'=>'!tips.edit'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.help_record.title'
						, 'placeholder' => 'Title'
					)
				) !!}
			</div>
			<div class="col-xs-5">
				{!! Form::button('Reject'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "tips.updateHelp(tips.help_record.id, 0)"
						, 'ng-if' => '!tips.edit'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Description <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::textarea('search_name', ''
					, array(
						'ng-disabled'=>'!tips.edit'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.help_record.content'
						, 'placeholder' => 'Description'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Created By</span></label>
			<div class="col-xs-5">
				{!! Form::text('search_name', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.help_record.created_by'
						, 'placeholder' => '>Created By'
					)
				) !!}
			</div>
		</div>
		<div class="btn-container">
			<div class="col-xs-6 col-xs-offset-3">
				{!! Form::button('Edit'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-if' => '!tips.edit'
						, 'ng-click' => "tips.setHelpActive('edit', tips.help_record.id)"
					)
				) !!}
				{!! Form::button('Save & Publish'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-if' => 'tips.edit'
						, 'ng-click' => "tips.saveEditHelp()"
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "tips.setHelpActive('list')"
						, 'ng-if' => '!tips.edit'
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "tips.setHelpActive('view', tips.help_record.id)"
						, 'ng-if' => 'tips.edit'
					)
				) !!}
			</div>
		</div>
    </div>
</div>