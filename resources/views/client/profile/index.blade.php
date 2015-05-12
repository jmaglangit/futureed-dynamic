@extends('client.app')

@section('navbar')
    @include('client.partials.main-nav')
@stop
@section('content')
	<div class="container dshbrd-con" ng-cloak>
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
					<div class="alert alert-error" ng-if="errors">
			            <p ng-repeat="error in errors" > 
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
	                                    , 'ng-disabled' => '!edit' 
	                                    , 'ng-model' => 'prof.username'
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
	                                    , 'ng-model' => 'prof.email'
	                                    , 'ng-model-options' => "{debounce : {'default' : 1000}}"
	                                    , 'ng-change' => "checkEmailAvailability(prof.email, 'Student')")
	                            ) !!}
	                        </div>
	                        <div class="col-xs-2">
	                        	<a href="#" class="edit-email">Edit</a>
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
	                                    , 'ng-model' => 'prof.email'
	                                    , 'ng-model-options' => "{debounce : {'default' : 1000}}"
	                                    , 'ng-change' => "checkEmailAvailability(prof.email, 'Student')")
	                            ) !!}
	                        </div>
	                        <div class="col-xs-2">
	                        	<a href="#" class="edit-email">Confirm</a>
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
	                                    , 'ng-disabled' => '!edit' 
	                                    , 'ng-model' => 'prof.first_name')
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
	                                    , 'ng-disabled' => '!edit' 
	                                    , 'ng-model' => 'prof.last_name')
	                            ) !!}
	                        </div>
	                    </div>
				</fieldset>
				<fieldset ng-if="!parent">
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
	                                , 'ng-disabled' => '!edit' 
	                                , 'ng-model' => 'prof.school_name')
	                        ) !!}
	                    </div>
	                </div>

	                <div class="form-group" ng-if="principal">
						<label for="" class="col-md-2 control-label">Address <span class="required">*</span></label>
	                    <div class="col-md-5">
	                        {!! Form::text('address', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'Address'
	                                , 'ng-disabled' => '!edit' 
	                                , 'ng-model' => 'prof.address')
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
	                                , 'ng-disabled' => '!edit' 
	                                , 'ng-model' => 'prof.city')
	                        ) !!}
	                    </div>
	                    <label for="" class="col-md-2 control-label">State <span class="required">*</span></label>
	                    <div class="col-md-4">
	                        {!! Form::text('state', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'City'
	                                , 'ng-disabled' => '!edit' 
	                                , 'ng-model' => 'prof.state')
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
	                                , 'ng-disabled' => '!edit' 
	                                , 'ng-model' => 'prof.postal_code')
	                        ) !!}
	                    </div>
	                    <label for="" class="col-md-2 control-label">Country <span class="required">*</span></label>
	                    <div class="col-md-4">
	                        <select name="country" class="form-control" ng-model="reg.country" ng-disabled="!edit">
                                <option value="">-- Select Country --</option>
                                <option ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                            </select>
	                    </div>
	                </div>
				</fieldset>
				<fieldset>
					<legend class="client-legend" ng-if="!parent">
						Other Address Information(Optional)
					</legend>
					<legend class="client-legend" ng-if="parent">
						Address
					</legend>
	                <div class="form-group">
						<label for="" class="col-md-2 control-label">Address <span class="required">*</span></label>
	                    <div class="col-md-5">
	                        {!! Form::text('address', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'Address'
	                                , 'ng-disabled' => '!edit' 
	                                , 'ng-model' => 'prof.address')
	                        ) !!}
	                    </div>
	                </div>
	                <div class="form-group">
						<label for="" class="col-md-2 control-label">City <span class="required">*</span></label>
	                    <div class="col-md-4">
	                        {!! Form::text('city', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'City'
	                                , 'ng-disabled' => '!edit' 
	                                , 'ng-model' => 'prof.city')
	                        ) !!}
	                    </div>
	                    <label for="" class="col-md-2 control-label">State <span class="required">*</span></label>
	                    <div class="col-md-4">
	                        {!! Form::text('state', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'City'
	                                , 'ng-disabled' => '!edit' 
	                                , 'ng-model' => 'prof.state')
	                        ) !!}
	                    </div>
	                </div>
	                <div class="form-group" ng-init="getCountries()">
						<label for="" class="col-md-2 control-label">Postal Code <span class="required">*</span></label>
	                    <div class="col-md-4">
	                        {!! Form::text('postal_code', ''
	                            , array(
	                                'class' => 'form-control'
	                                , 'placeholder' => 'Postal Code'
	                                , 'ng-disabled' => '!edit' 
	                                , 'ng-model' => 'prof.postal_code')
	                        ) !!}
	                    </div>
	                    <label for="" class="col-md-2 control-label">Country <span class="required">*</span></label>
	                    <div class="col-md-4">
	                        <select name="country" class="form-control" ng-model="reg.country" ng-disabled="!edit">
                                <option value="">-- Select Country --</option>
                                <option ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                            </select>
	                    </div>
	                </div>
				</fieldset>
				<div class="form-group">
					<div class="btncon-client col-xs-6" style="text-align:center;" ng-if="edit">
						<a class="btn btn-blue" ng-click="editProfile()">Edit</a>
					</div>
					<div class="btncon-client col-xs-6 col-xs-offset-3" style="text-align:center;" ng-if="!edit">
						<a class="btn btn-blue" ng-click="editProfile()">Edit</a>
					</div>
					<div class="btncon-client col-xs-6" style="text-align:center;" ng-if="edit">
						<a class="btn btn-gold" ng-click="setActive('index')">Cancel</a>
					</div>	
				</div>
				</div>
			</div>
		</div>		
	</div>
@stop

@section('footer')

@section('scripts')

@stop