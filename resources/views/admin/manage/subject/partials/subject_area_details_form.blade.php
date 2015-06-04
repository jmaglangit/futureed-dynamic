<div ng-if="area.active_details">
    <div class="content-title">
        <div class="title-main-content">
            <span>Update Subject Area</span>
        </div>
    </div>

	{!! Form::open(array('id'=> 'subject_area_details_form', 'class' => 'form-horizontal')) !!}
        <div class="form-content col-xs-12">
    		<div class="alert alert-error" ng-if="area.errors">
                <p ng-repeat="error in area.errors track by $index" > 
                  	{! error !}
                </p>
            </div>

            <div class="alert alert-success" ng-if="area.record.success">
                <p>{! area.record.success !}</p>
            </div>

            <fieldset>
            	<div class="form-group">
            		<label class="col-xs-3 control-label">Subject Code <span class="required">*</span></label>
            		<div class="col-xs-5">
            			{!! Form::text('subject_id',''
            				, array(
            					'placeHolder' => 'Subject Code'
            					, 'ng-model' => 'area.record.subject_id'
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
            					, 'ng-model' => 'area.record.subject_name'
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
            					, 'ng-model' => 'area.record.code'
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
            					, 'ng-model' => 'area.record.name'
            					, 'class' => 'form-control'
            				)
            			) !!}
            		</div>
            	</div>
                <div class="form-group">
                        <label class="col-xs-3 control-label">Description</label>
                        <div class="col-xs-5">
                            {!! Form::textarea('description','',
                            [
                                'id'=> 'description',
                                'class' => 'form-control',
                                'ng-model' => 'area.record.description',
                                'rows' => '5'
                            ]) !!}
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
            							, 'ng-model' => 'area.record.status'
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
            							, 'ng-model' => 'area.record.status'
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
            			, 'ng-click' => 'area.update()'
            		)
            	) !!}

                {!! Form::button('Cancel'
                    , array(
                        'class' => 'btn btn-gold btn-medium'
                        , 'ng-click' => "area.setActive()"
                    )
                ) !!}
    	     </div>
        </div>
	{!! Form::close() !!}
</div>