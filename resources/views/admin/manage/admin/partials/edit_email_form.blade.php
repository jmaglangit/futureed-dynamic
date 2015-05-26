<div ng-if="admin.active_edit_email">
    <div class="content-title">
        <div class="title-main-content" ng-if="!admin.edit_admin">
            <span>Edit Email Address</span>
        </div>
    </div>

    {!! Form::open(
    	array(
    		  'id' => 'edit_email_form'
    		, 'class' => 'form-horizontal'
    	)
    ) !!}
    <div class="form-content col-xs-12">
    	<div class="form-group">
    		<label class="col-xs-3 control-label">New Email Address <span class="required">*</span></label>
    		<div class="col-xs-5">
        		{!! Form::text('new_email', ''
        			, array(
            			'class' => 'form-control'
            			, 'placeholder' => 'New Email Address'
            			, 'ng-model' => 'admin.change.new_email'
            			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
            			, 'ng-change' => 'admin.validateNewAdminEmail()') 
            		)!!}
            </div>		
            <div style="margin-top: 7px;"> 
                <i ng-if="admin.validation.n_loading" class="fa fa-spinner fa-spin"></i>
                <i ng-if="admin.validation.n_success" class="fa fa-check success-color"></i>
                <span ng-if="admin.validation.n_error" class="error-msg-con">{! admin.validation.n_error !}</span>
            </div>	
    	</div>
    	<div class="form-group">
    		<label class="col-xs-3 control-label">Confirm Email Address <span class="required">*</span></label>
    		<div class="col-xs-5">
        		{!! Form::text('confirm_email', ''
        			, array(
            			'class' => 'form-control'
            			, 'placeholder' => 'Confirm Email Address'
            			, 'ng-model' => 'admin.change.confirm_email'
            			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
            			, 'ng-change' => 'admin.confirmNewEmail()') 
            		)!!}
            </div>
            <div style="margin-top: 7px;"> 
                <i ng-if="admin.validation.c_success" class="fa fa-check success-color"></i>
                <span ng-if="admin.validation.c_error" class="error-msg-con">{! admin.validation.c_error !}</span>
            </div>	
    	</div>
    	<div class="btn-container">
    		{!! Form::button('Save'
                , array(
                    'class' => 'btn btn-gold btn-medium'
                    , 'ng-click' => "admin.changeAdminEmail()"
                )
            ) !!}

            {!! Form::button('Cancel'
                , array(
                    'class' => 'btn btn-blue btn-medium'
                    , 'ng-click' => "admin.viewAdmin(admin.admininfo.id)"
                )
            ) !!}
    	</div>
    </div>
    {!! Form::close() !!}
</div>