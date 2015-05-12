@extends('client.app')

@section('navbar')
    @include('client.partials.main-nav')
@stop
@section('content')
	<div class="container dshbrd-con" ng-controller="ProfileController as profile" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')				
			</div>
			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content">
						My Profile
					</div>
				</div>
				<div class="form-content col-xs-12">
					<div class="alert alert-error" ng-if="profile.errors">
			            <p ng-repeat="error in profile.errors" > 
			              {! error !}
			            </p>
			        </div>
	                <div class="alert alert-success" ng-if="success">
	                	<p>Successfully update profile.</p>
	                </div>
	                {!! Form::open(array('id' => 'client_profile_form', 'class' => 'form-horizontal')) !!}
					<fieldset>
						<legend class="client-legend">
							User Credentials
						</legend>
						<div class="form-group">
							<label for="" class="col-md-2 control-label">Username <span class="required">*</span></label>
							<div class="col-xs-5">
								{!! Form::text('username', ''
	                                , array(
	                                    'class' => 'form-control'
	                                    , 'placeholder' => 'Username' 
	                                    , 'ng-disabled' => '!profile.edit' 
	                                    , 'ng-model' => 'profile.prof.username'
	                                    , 'ng-model-options' => "{debounce : {'default' : 1000}}"
	                                    , 'ng-change' => "checkAvailability(prof.username, 'Student')")
	                            ) !!}
							</div>
							<div style="margin-top: 7px;"> 
	                            <i ng-if="u_loading" class="fa fa-spinner fa-spin"></i>
	                            <i ng-if="u_success" class="fa fa-check success-color"></i>
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
	                                    , 'ng-disabled' => 'true' 
	                                    , 'ng-model' => 'profile.prof.email'
	                                )
	                            ) !!}
	                        </div>
	                        <div class="col-xs-2">
	                        	<!-- <a href="#" class="edit-email">Edit</a> -->
	                        </div>	
	                    </div>
	                    {{-- show if there is a pending email --}}
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label" style="color:#7F7504">Pending Email <span class="required">*</span></label>
	                        <div class="col-md-5">
	                        	{!! Form::text('email', ''
	                                , array(
	                                    'class' => 'form-control'
	                                    , 'placeholder' => 'Email Address' 
	                                    , 'ng-disabled' => 'true' 
	                                    , 'ng-model' => 'profile.prof.pending_email'
	                                )
	                            ) !!}
	                        </div>
	                        <div class="col-xs-2">
	                        	<!-- <a href="#" class="edit-email">Confirm</a> -->
	                        </div>	
	                    </div>
				</fieldset>
				<fieldset>
					<legend class="client-legend">
						Personal Information
					</legend>
					<div class="form-group">
	                        <label for="" class="col-md-2 control-label">First Name <span class="required">*</span></label>
	                        <div class="col-md-5">
		                        {!! Form::text('first_name', ''
	                                , array(
	                                    'class' => 'form-control'
	                                    , 'placeholder' => 'First Name'
	                                    , 'ng-disabled' => '!profile.edit' 
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
	                                    , 'ng-disabled' => '!profile.edit' 
	                                    , 'ng-model' => 'profile.prof.last_name')
	                            ) !!}
	                        </div>
	                    </div>
				</fieldset>

				<fieldset ng-if="profile.is_teacher">
					<legend class="client-legend">
						School Information
					</legend>
					<div class="form-group">
						<label for="" class="col-md-2 control-label">School Name <span class="required">*</span></label>
	                    <div class="col-md-5">
	                        {!! Form::text('school_name', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'School Name'
	                                , 'ng-disabled' => '!profile.edit' 
	                                , 'ng-model' => 'profile.prof.school_name')
	                        ) !!}
	                    </div>
	                </div>
				</fieldset>

				<fieldset ng-if="profile.is_principal">
					<legend class="client-legend">
						School Information
					</legend>
					<div class="form-group">
						<label for="" class="col-md-2 control-label">School Name <span class="required">*</span></label>
	                    <div class="col-md-5">
	                        {!! Form::text('school_name', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'School Name'
	                                , 'ng-disabled' => '!profile.edit' 
	                                , 'ng-model' => 'profile.prof.school_name')
	                        ) !!}
	                    </div>
	                </div>
	                <div class="form-group">
						<label for="" class="col-md-2 control-label">Street Address <span class="required">*</span></label>
	                    <div class="col-md-5">
	                        {!! Form::text('street_address', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'Address'
	                                , 'ng-disabled' => '!profile.edit' 
	                                , 'ng-model' => 'profile.prof.school_street_address')
	                        ) !!}
	                    </div>
	                </div>
	                <div class="form-group" ng-if="principal">
						<label for="" class="col-md-2 control-label">City <span class="required">*</span></label>
	                    <div class="col-md-4">
	                        {!! Form::text('city', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'City'
	                                , 'ng-disabled' => '!profile.edit' 
	                                , 'ng-model' => 'profile.prof.school_city')
	                        ) !!}
	                    </div>
	                    <label for="" class="col-md-2 control-label">State <span class="required">*</span></label>
	                    <div class="col-md-4">
	                        {!! Form::text('state', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'City'
	                                , 'ng-disabled' => '!profile.edit' 
	                                , 'ng-model' => 'profile.prof.school_state')
	                        ) !!}
	                    </div>
	                </div>
	                <div class="form-group" ng-init="getCountries()" ng-if="principal">
						<label for="" class="col-md-2 control-label">Postal Code <span class="required">*</span></label>
	                    <div class="col-md-4">
	                        {!! Form::text('postal_code', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'Postal Code'
	                                , 'ng-disabled' => '!profile.edit' 
	                                , 'ng-model' => 'profile.prof.school_zip')
	                        ) !!}
	                    </div>
	                    <label for="" class="col-md-2 control-label">Country <span class="required">*</span></label>
	                    <div class="col-md-4">
	                        <select name="country" class="form-control" ng-model="profile.prof.school_country" ng-disabled="!profile.edit">
                                <option selected="selected" value="">-- Select Country --</option>
                                <option ng-selected="{! profile.prof.school_country == country.id !}" ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                            </select>
	                    </div>
	                </div>
				</fieldset>
				<fieldset>
					<legend class="client-legend" ng-if="!profile.is_parent">
						Other Address Information(Optional)
					</legend>
					<legend class="client-legend" ng-if="profile.is_parent">
						Address Information
					</legend>
	                <div class="form-group">
						<label for="" class="col-md-2 control-label">Street Address <span class="required">*</span></label>
	                    <div class="col-md-5">
	                        {!! Form::text('street_address', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'Address'
	                                , 'ng-disabled' => '!profile.edit' 
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
	                                , 'ng-disabled' => '!profile.edit' 
	                                , 'ng-model' => 'profile.prof.city')
	                        ) !!}
	                    </div>
	                    <label for="" class="col-md-2 control-label">State <span class="required" ng-if="profile.is_required">*</span></label>
	                    <div class="col-md-4">
	                        {!! Form::text('state', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'City'
	                                , 'ng-disabled' => '!profile.edit' 
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
	                                , 'ng-disabled' => '!profile.edit' 
	                                , 'ng-model' => 'profile.prof.zip')
	                        ) !!}
	                    </div>
	                    <label for="" class="col-md-2 control-label">Country <span class="required" ng-if="profile.is_required">*</span></label>
	                    <div class="col-md-4">
	                        <select name="country" class="form-control" ng-model="profile.prof.country" ng-disabled="!profile.edit">
                                <option selected="selected" value="">-- Select Country --</option>
                                <option ng-selected="{! profile.prof.country == country.id !}" ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                            </select>
	                    </div>
	                </div>
				</fieldset>
				{!! Form::close() !!}
				<div class="btn-container">
					{!! Form::button('Edit'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "profile.setClientProfileActive('edit')"
							, 'ng-if' => '!profile.edit'
						)
					) !!}

					{!! Form::button('Save'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => 'profile.saveClientProfile()'
							, 'ng-if' => 'profile.edit'
						)
					) !!}

					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "profile.setClientProfileActive('index')"
						)
					) !!}
				</div>
				</div>
			</div>
		</div>		
	</div>
@stop

@section('footer')

@section('scripts')
	
	{!! Html::script('/js/client/controllers/profile_controller.js') !!}
	{!! Html::script('/js/client/services/profile_service.js') !!}

@stop