<div ng-if="subject.active_add_subject">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Subject</span>
		</div>
	</div>

	{!! Form::open(array('id'=> 'add_subject_form', 'class' => 'form-horizontal')) !!}
		<div class="form-content col-xs-12">
			<div class="alert alert-error" ng-if="subject.errors">
	            <p ng-repeat="error in subject.errors track by $index" > 
	              	{! error !}
	            </p>
	        </div>

	        <div class="alert alert-success" ng-if="subject.create.success">
	        	<p>Successfully added new subject.</p>
	        </div>

	        <fieldset>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="email">Subject Code <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('code',''
	        				, array(
	        					'placeHolder' => 'Subject Code'
	        					, 'ng-model' => 'subject.create.code'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">Subject <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('name',''
	        				, array(
	        					'placeHolder' => 'Subject Name'
	        					, 'ng-model' => 'subject.create.name'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">Description </label>
	        		<div class="col-xs-5">
	        			<textarea name="description" ng-model="subject.create.description" class="form-control" cols="50" rows="10"></textarea>
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			<div class="col-xs-6 checkbox">	                				
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Enabled'
	        						, true
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'subject.create.status'
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
	        							, 'ng-model' => 'subject.create.status'
	        						)
	        					) !!}
	        				<span class="lbl padding-8">Disabled</span>
	        				</label>
	        			</div>
	        		</div>
	        	</div>
	        </fieldset>
	        <div class="btn-container col-sm-7 col-sm-offset-1">
	        	{!! Form::button('Save'
	        		, array(
	        			'class' => 'btn btn-blue btn-medium'
	        			, 'ng-click' => 'subject.addNewSubject()'
	        		)
	        	) !!}

	        	{!! Form::button('Cancel'
	        		, array(
	        			'class' => 'btn btn-gold btn-medium'
	        			, 'ng-click' => 'subject.setManageSubjectActive()'
	        		)
	        	) !!}
		     </div>
		</div>
	{!! Form::close() !!}
</div>