<div class="clearfix"></div>
<div class="container search-container" ng-if="tips.active_edit">
	<div class="title-mid">
		<span>Edit Tip</span>		
	</div>
	<div class="col-xs-12 success-container" ng-if="tips.errors || tips.success">
		<div class="alert alert-error" ng-if="tips.errors">
            <p ng-repeat="error in tips.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="tips.success">
            <p>{! class.success !}</p>
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
						, 'ng-model' => 'tips.record.created_at'
						, 'placeholder' => 'Date Created'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Title <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('search_name', ''
					, array(
						'class' => 'form-control'
						, 'ng-model' => 'tips.record.title'
						, 'placeholder' => 'Title'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Description <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::textarea('search_name', ''
					, array(
						'class' => 'form-control'
						, 'ng-model' => 'tips.record.content'
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
						, 'ng-model' => 'tips.record.created_by'
						, 'placeholder' => 'Created By'
					)
				) !!}
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="btn-container col-xs-12">
			<div class="col-xs-8 col-xs-offset-2">
				<div class="col-xs-6">
					{!! Form::button('Save & Publish'
						, array(
							'class' => 'btn btn-blue semi-large'
							, 'ng-click' => "tips.saveEdit()"
						)
					) !!}
				</div>
				<div class="col-xs-6">
					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-gold'
							, 'ng-click' => "tips.setTipsActive('view', tips.record.id)"
						)
					) !!}
				</div>
			</div>
		</div>
    </div>
</div>