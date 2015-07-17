<div class="clearfix"></div>
<div class="container search-container" ng-if="tips.help_ans_active_view">
	<div class="title-mid">
		<span>View Help Request Answer</span>		
	</div>
	<div class="col-xs-12 success-container" ng-if="tips.help_ans_errors || tips.help_ans_success">
		<div class="alert alert-error" ng-if="tips.help_ans_errors">
            <p ng-repeat="error in tips.help_ans_errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="tips.help_ans_success">
            <p>{! tips.help_ans_success !}</p>
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
						, 'ng-model' => 'tips.help_ans_record.subject'
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
						, 'ng-model' => 'tips.help_ans_record.subject_area'
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
						, 'ng-model' => 'tips.help_ans_record.module'
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
						, 'ng-model' => 'tips.help_ans_record.created_at'
						, 'placeholder' => 'Date Created'
					)
				) !!}
			</div>
			<div class="col-xs-5">
				{!! Form::button('Approve'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "tips.updateHelpAns(tips.help_ans_record.id, 1)"
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Title <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('title', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.help_ans_record.title'
						, 'placeholder' => 'Title'
					)
				) !!}
			</div>
			<div class="col-xs-5">
				{!! Form::button('Reject'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "tips.updateHelpAns(tips.help_ans_record.id, 0)"
						, 'ng-if' => '!tips.help_ans_edit'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Description <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::textarea('search_name', ''
					, array(
						'ng-disabled'=>'!tips.help_ans_edit'
						, 'class' => 'form-control'
						, 'ng-model' => 'tips.help_ans_record.content'
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
						, 'ng-model' => 'tips.help_ans_record.created_by'
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
						, 'ng-if' => '!tips.help_ans_edit'
						, 'ng-click' => "tips.setHelpAnsActive('edit', tips.help_ans_record.id)"
						, 'ng-if' => '!tips.help_ans_edit'
					)
				) !!}
				{!! Form::button('Save & Publish'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-if' => 'tips.help_ans_edit'
						, 'ng-click' => "tips.saveEditHelpAns()"
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "tips.setHelpAnsActive('list')"
					)
				) !!}
			</div>
		</div>
    </div>
</div>