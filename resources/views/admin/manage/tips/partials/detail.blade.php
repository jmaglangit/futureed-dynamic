<div ng-if="tips.active_view || tips.active_edit">
	<div class="module-container">
		<div class="title-main-content">
			<span>Tip Detail</span>
		</div>
	</div>
	
	<div class="form-content col-xs-12">
		{!! Form::open([
				'id' => 'add_admin_form',
				'class' => 'form-horizontal'
			]) 
		!!}
			<fieldset>
				<div class="form-group">
					<label class="col-xs-2 control-label" id="username">Module <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('username', '',
							[
								'placeholder' => 'Module',
								'ng-disabled' => 'true',
								'ng-model' => 'tips.record.module',
								'class' => 'form-control'
							]
						) !!}
					</div>
					<label class="col-xs-2 control-label" id="email">Type <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::select('link_type'
							, array(
								'' => '-- Select Type --'
								, 'General' => 'General'
								, 'Content' => 'Content'
								, 'Question' => 'Question'
							)
							, ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'tips.record.link_type'
								, 'ng-disabled' => 'tips.active_view'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Subject <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('subject', '',
							[
								'placeholder' => 'Subject',
								'ng-disabled' => 'true',
								'ng-model' => 'tips.record.subject',
								'class' => 'form-control'
							]
						) !!}
					</div>
					<label class="col-xs-2 control-label">Area <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('area', '',
							[
								'placeholder' => 'Area',
								'ng-disabled' => 'true',
								'ng-model' => 'tips.record.area',
								'class' => 'form-control'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
	        		<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
	        		<div class="col-xs-4" ng-if="tips.active_edit">
	        			<div class="col-xs-6 checkbox">	                				
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Enabled'
	        						, true
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'tips.record.status'
	        						) 
	        					) !!}
	        				<span class="lbl padding-8">Enabled</span>
	        				</label>
	        			</div>
	        			<div class="col-xs-6 checkbox">
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Disabled'
	        						, false
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'tips.record.status'
	        						)
	        					) !!}
	        				<span class="lbl padding-8">Disabled</span>
	        				</label>
	        			</div>
	        		</div>
	        		<div ng-if="tips.active_view">
		        		<label class="col-md-5" ng-if="tips.record.status == 'Enabled'">
		        			<b class="success-icon">
		        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! tips.record.status !}
		        			</b>
		        		</label>

		        		<label class="col-md-5" ng-if="tips.record.status !== 'Enabled'">
		        			<b class="error-icon">
		        				<i class="margin-top-8 fa fa-ban"></i> Disabled {! tips.record.status !}
		        			</b>
		        		</label>
	        		</div>
	        	</div>
			</fieldset>
			<fieldset>
				<legend class="legend-name-mid">
					Tip Content
				</legend>
				<div class="form-group">
					<label class="col-xs-3 control-label">Title <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::text('title', '',
							[
								'class' => 'form-control',
								'ng-disabled' => 'tips.active_view',
								'ng-model' => 'tips.record.title',
								'placeholder' => 'Title'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Description <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::textarea('description','',
							[
								'class' => 'form-control',
								'ng-disabled' => 'tips.active_view',
								'ng-model' => 'tips.record.description',
								'placeholder' => 'Description'
							]
						) !!}
					</div>
				</div>
				<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="tips.active_edit">
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "tips.updateTip()"
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "tips.setActive(futureed.ACTIVE_VIEW)"
							)
						) !!}
				</div>	
				<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="tips.active_view">
						{!! Form::button('Edit'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "tips.setActive(futureed.ACTIVE_EDIT)"
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "tips.setActive()"
							)
						) !!}		
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>