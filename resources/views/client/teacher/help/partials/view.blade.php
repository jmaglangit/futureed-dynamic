<div class="row module-container" ng-if="help.active_view || help.active_edit">
	<div class="title-mid">
		<span>Help Request Details</span>		
	</div>
	
    <div class="form-content col-xs-12">
    	{!! Form::open(
			array(
				'id' => 'help_detail_form'
				, 'class' => 'form-horizontal'
			)
		) !!}
		<div class="alert alert-error" ng-if="help.errors">
            <p ng-repeat="error in help.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="help.success">
            <p>{! help.success !}</p>
        </div>

        <fieldset>
			<div class="form-group" ng-if="help.record.link_type == futureed.CONTENT && help.record.subject">
				<label class="control-label col-xs-3">Subject</label>
				<div class="col-xs-5">
					{!! Form::text('subject', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'help.record.subject'
							, 'placeholder' => 'Subject'
						)
					) !!}
				</div>
			</div>

			<div class="form-group" ng-if="help.record.link_type == futureed.CONTENT && help.record.subjectarea">
				<label class="control-label col-xs-3">Subject Area</label>
				<div class="col-xs-5">
					{!! Form::text('subjectarea', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'help.record.subjectarea'
							, 'placeholder' => 'Subject Area'
						)
					) !!}
				</div>
			</div>

			<div class="form-group" ng-if="help.record.link_type == futureed.CONTENT && help.record.module">
				<label class="control-label col-xs-3">Module</label>
				<div class="col-xs-5">
					{!! Form::text('module', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'help.record.module'
							, 'placeholder' => 'Module'
						)
					) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3">Title <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_name', ''
						, array(
							'ng-disabled'=>'help.active_view'
							, 'class' => 'form-control'
							, 'ng-model' => 'help.record.title'
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
							'ng-disabled'=>'help.active_view'
							, 'class' => 'form-control disabled-textarea'
							, 'ng-model' => 'help.record.content'
							, 'placeholder' => 'Description'
						)
					) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3">Date Created</label>
				<div class="col-xs-5">
					<input type="text" ng-disabled="true" class="form-control" placeholder="Date Created" 
						value="{! help.record.created_at | ddMMyy : '-' !}" />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3">Created By</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_name', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'help.record.created_by'
							, 'placeholder' => 'Created By'
						)
					) !!}
				</div>
			</div>

			<div class="form-group" ng-if="help.active_view && help.record.tip_status == futureed.PENDING">
				<div class="btn-container col-xs-8 col-xs-offset-1">
					{!! Form::button('Approve'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "help.updateStatus(help.record.id, futureed.TRUE)"
						)
					) !!}
					{!! Form::button('Reject'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "help.updateStatus(help.record.id, futureed.FALSE)"
						)
					) !!}
				</div>
			</div>

			<div class="form-group" ng-if="help.active_view">
				<div class="btn-container col-xs-8 col-xs-offset-1">
					{!! Form::button('Edit'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "help.setActive(futureed.ACTIVE_EDIT, help.record.id)"
						)
					) !!}
					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "help.setActive(futureed.ACTIVE_LIST)"
						)
					) !!}
				</div>
			</div>

			<div class="form-group" ng-if="help.active_edit">
				<div class="btn-container col-xs-8 col-xs-offset-1">
					{!! Form::button('Save'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "help.update()"
						)
					) !!}
					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "help.setActive(futureed.ACTIVE_VIEW, help.record.id)"
						)
					) !!}
				</div>
			</div>
		</fieldset>
		{!! Form::close() !!}
    </div>
</div>