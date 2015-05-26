<div ng-show="subject.active_subject_area_add">
	{!! Form::open(array('id'=> 'add_subject_area_form', 'class' => 'form-horizontal')) !!}
		<div class="alert alert-error" ng-if="subject.errors">
            <p ng-repeat="error in subject.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <fieldset>
        	<div class="form-group">
        		<label class="col-xs-3 control-label">Subject Code <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('subject_id',''
        				, array(
        					'placeHolder' => 'Subject Code'
        					, 'ng-model' => 'subject.create_area.subject_id'
        					, 'ng-disabled' => 'true'
        					, 'class' => 'form-control'
        				)
        			) !!}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="col-xs-3 control-label">Subject <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('subject_id',''
        				, array(
        					'placeHolder' => 'Subject Name'
        					, 'ng-model' => 'subject.create_area.subject_name'
        					, 'ng-disabled' => 'true'
        					, 'class' => 'form-control'
        				)
        			) !!}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="col-xs-3 control-label">Area Code <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('code',''
        				, array(
        					'placeHolder' => 'Area Code'
        					, 'ng-model' => 'subject.create_area.code'
        					, 'class' => 'form-control'
        				)
        			) !!}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="col-xs-3 control-label">Area <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('name',''
        				, array(
        					'placeHolder' => 'Area'
        					, 'ng-model' => 'subject.create_area.name'
        					, 'class' => 'form-control'
        				)
        			) !!}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="col-xs-3 control-label">Status <span class="required">*</span></label>
        		<div class="col-xs-5">
        			<div class="col-xs-6 checkbox">	                				
        				<label>
        					{!! Form::radio('status'
        						, 'Enabled'
        						, true
        						, array(
        							'class' => 'field'
        							, 'ng-model' => 'subject.create_area.status'
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
        							, 'ng-model' => 'subject.create_area.status'
        						)
        					) !!}
        				<span class="lbl padding-8">Disabled</span>
        				</label>
        			</div>
        		</div>
        	</div>
        </fieldset>
        <div class="btn-container col-sm-7 col-sm-offset-2">
        	{!! Form::button('Save'
        		, array(
        			'class' => 'btn btn-blue btn-large'
        			, 'ng-click' => 'subject.addNewSubjectArea()'
        		)
        	) !!}
	     </div>
	{!! Form::close() !!}
</div>