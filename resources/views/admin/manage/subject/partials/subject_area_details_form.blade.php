<div ng-show="subject.active_subject_area_details">
	{!! Form::open(array('id'=> 'subject_area_details_form', 'class' => 'form-horizontal')) !!}
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
        					, 'ng-model' => 'subject.area_details.subject_id'
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
        					, 'ng-model' => 'subject.area_details.subject_name'
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
        					, 'ng-model' => 'subject.area_details.code'
                            , 'ng-disabled' => 'true'
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
        					, 'ng-model' => 'subject.area_details.name'
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
        							, 'ng-model' => 'subject.area_details.status'
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
        							, 'ng-model' => 'subject.area_details.status'
        						)
        					) !!}
        				<span class="lbl padding-8">Disabled</span>
        				</label>
        			</div>
        		</div>
        	</div>
        </fieldset>
        <div class="btn-container col-sm-9 col-sm-offset-1">
        	{!! Form::button('Update'
        		, array(
        			'class' => 'btn btn-blue btn-medium'
        			, 'ng-click' => 'subject.updateSubjectAreaDetails()'
        		)
        	) !!}

            {!! Form::button('Cancel'
                , array(
                    'class' => 'btn btn-gold btn-medium'
                    , 'ng-click' => "subject.setManageSubjectActive('subject_area_list')"
                )
            ) !!}
	     </div>
	{!! Form::close() !!}
</div>