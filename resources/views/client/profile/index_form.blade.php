{!! Form::open(array('id' => 'client_profile_form', 'class' => 'form-horizontal', 'ng-if' => 'profile.active_index || profile.active_edit')) !!}
    <fieldset>
    	<legend class="legend-name-mid">
    		User Credentials
    	</legend>
    	<div class="form-group">
    		<label for="" class="col-md-2 control-label">Username <span class="required">*</span></label>
    		<div class="col-xs-5">
    			{!! Form::text('username', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Username' 
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.username'
                        , 'ng-model' => 'profile.prof.username'
                        , 'ng-model-options' => "{debounce : {'default' : 1000} }"
                        , 'ng-change' => "checkAvailability(profile.prof.username, 'Student')")
                ) !!}
    		</div>
    		<div style="margin-top: 7px;"> 
                <i ng-if="u_loading" class="fa fa-spinner fa-spin"></i>
                <span ng-if="u_success" class="alert alert-success">{! u_success !}</span>
                <span ng-if="u_error" class="alert alert-error">{! u_error !}</span>
            </div>		
    	</div>
    	<div class="form-group">
            <label for="" class="col-md-2 control-label">Email <span class="required">*</span></label>
            <div class="col-md-5">
            	{!! Form::text('email', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Email Address' 
                        , 'readonly' => 'readonly' 
                        , 'ng-model' => 'profile.prof.email'
                    )
                ) !!}
            </div>
            <div class="col-xs-2">
            	<a href="" ng-click="profile.setClientProfileActive('edit_email')" class="edit-email">Edit</a>
            </div>	
        </div>
        
        <div class="form-group" ng-if='profile.prof.new_email'>
            <label for="" class="col-md-2 control-label" style="color:#7F7504">Pending Email <span class="required">*</span></label>
            <div class="col-md-5">
            	{!! Form::text('email', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Email Address' 
                        , 'readonly' => 'readonly' 
                        , 'ng-model' => 'profile.prof.new_email'
                    )
                ) !!}
            </div>
            <div class="col-xs-2">
                <a href="" ng-click="profile.setClientProfileActive('confirm_email')" class="edit-email">Confirm</a>
            </div>	
        </div>
    </fieldset>

    <fieldset>
    	<legend class="legend-name-mid">
    		Personal Information
    	</legend>
    	<div class="form-group">
                <label for="" class="col-md-2 control-label">First Name <span class="required">*</span></label>
                <div class="col-md-5">
                    {!! Form::text('first_name', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => 'First Name'
                            , 'ng-disabled' => '!profile.active_edit' 
                            , 'ng-model' => 'profile.prof.first_name')
                    ) !!}
                </div>
            </div>
    		<div class="form-group">
                <label for="" class="col-md-2 control-label">Last Name <span class="required">*</span></label>
                <div class="col-md-5">
                	{!! Form::text('last_name', ''
                        , array(
                            'class' => 'form-control'
                            , 'placeholder' => 'Last Name'
                            , 'ng-disabled' => '!profile.active_edit' 
                            , 'ng-model' => 'profile.prof.last_name')
                    ) !!}
                </div>
            </div>
    </fieldset>

    <fieldset ng-if="profile.is_teacher">
    	<legend class="legend-name-mid">
    		School Information
    	</legend>
    	<div class="form-group">
    		<label for="" class="col-md-2 control-label">School Name <span class="required">*</span></label>
            <div class="col-md-5">
                {!! Form::text('school_name', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'School Name'
                        , 'ng-disabled' => 'true' 
                        , 'ng-model' => 'profile.prof.school_name')
                ) !!}
            </div>
        </div>
    </fieldset>

    <fieldset ng-if="profile.is_principal">
    	<legend class="legend-name-mid">
    		School Information
    	</legend>
    	<div class="form-group">
    		<label for="" class="col-md-2 control-label">School Name <span class="required">*</span></label>
            <div class="col-md-5">
                {!! Form::text('school_name', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'School Name'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.school_name')
                ) !!}
            </div>
        </div>
        <div class="form-group">
    		<label for="" class="col-md-2 control-label">Street Address </label>
            <div class="col-md-5">
                {!! Form::text('school_street_addres', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Address'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.school_street_address')
                ) !!}
            </div>
        </div>
        <div class="form-group">
    		<label for="" class="col-md-2 control-label">City </label>
            <div class="col-md-4">
                {!! Form::text('school_city', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'City'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.school_city')
                ) !!}
            </div>
            <label for="" class="col-md-2 control-label">State <span class="required">*</span></label>
            <div class="col-md-4">
                {!! Form::text('school_state', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'City'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.school_state')
                ) !!}
            </div>
        </div>
        <div class="form-group" ng-init="getCountries()">
    		<label for="" class="col-md-2 control-label">Postal Code</label>
            <div class="col-md-4">
                {!! Form::text('school_zip', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Postal Code'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.school_zip')
                ) !!}
            </div>
            <label for="" class="col-md-2 control-label">Country <span class="required">*</span></label>
            <div class="col-md-4">
                <select name="school_country" class="form-control" ng-model="profile.prof.school_country" ng-disabled="!profile.active_edit">
                    <option selected="selected" value="">-- Select Country --</option>
                    <option ng-selected="{! profile.prof.school_country == country.id !}" ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                </select>
            </div>
        </div>
    </fieldset>
    <fieldset>
    	<legend class="legend-name-mid" ng-if="!profile.is_parent">
    		Other Address Information(Optional)
    	</legend>
    	<legend class="legend-name-mid" ng-if="profile.is_parent">
    		Address Information
    	</legend>
        <div class="form-group">
    		<label for="" class="col-md-2 control-label">Street Address <span class="required" ng-if="profile.is_required">*</span></label>
            <div class="col-md-5">
                {!! Form::text('street_address', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Address'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.street_address')
                ) !!}
            </div>
        </div>
        <div class="form-group">
    		<label for="" class="col-md-2 control-label">City <span class="required" ng-if="profile.is_required">*</span></label>
            <div class="col-md-4">
                {!! Form::text('city', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'City'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.city')
                ) !!}
            </div>
            <label for="" class="col-md-2 control-label">State <span class="required" ng-if="profile.is_required">*</span></label>
            <div class="col-md-4">
                {!! Form::text('state', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'City'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.state')
                ) !!}
            </div>
        </div>
        <div class="form-group" ng-init="getCountries()">
    		<label for="" class="col-md-2 control-label">Postal Code <span class="required" ng-if="profile.is_required">*</span></label>
            <div class="col-md-4">
                {!! Form::text('zip', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Postal Code'
                        , 'ng-disabled' => '!profile.active_edit' 
                        , 'ng-model' => 'profile.prof.zip')
                ) !!}
            </div>
            <label for="" class="col-md-2 control-label">Country <span class="required" ng-if="profile.is_required">*</span></label>
            <div class="col-md-4">
                <select name="country" class="form-control" ng-model="profile.prof.country" ng-disabled="!profile.active_edit">
                    <option selected="selected" value="">-- Select Country --</option>
                    <option ng-selected="{! profile.prof.country == country.id !}" ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                </select>
            </div>
        </div>
    </fieldset>

    <div class="btn-container">
        {!! Form::button('Edit'
            , array(
                'class' => 'btn btn-gold btn-medium'
                , 'ng-click' => "profile.setClientProfileActive('edit')"
                , 'ng-if' => '!profile.active_edit'
            )
        ) !!}

        {!! Form::button('Save'
            , array(
                'class' => 'btn btn-gold btn-medium'
                , 'ng-click' => 'profile.saveClientProfile()'
                , 'ng-if' => 'profile.active_edit'
            )
        ) !!}

        {!! Form::button('Cancel'
            , array(
                'class' => 'btn btn-blue btn-medium'
                , 'ng-click' => "profile.setClientProfileActive('index')"
                , 'ng-if' => 'profile.active_edit'
            )
        ) !!}
    </div>
{!! Form::close() !!}