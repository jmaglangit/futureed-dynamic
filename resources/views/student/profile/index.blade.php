@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
<div class="container dshbrd-con" ng-cloak>
	<div class="wrapr"> 
		<div class="side-nav">
			@include('student.partials.dshbrd-side-nav')
		</div>
		<div class="content">
			<div class="hdr">
				<div class="avtrcon">
					<img ng-src="{! user.avatar !}">
				</div>
				<div class="detcon">
					<div class="rwrdscon">
						<h3>
							<div class="rbn-left"></div>
							<div class="rbn-right"></div>
							Quick <span>Rewards</span>
						</h3>
						<div class="points">
							<span class="star">☆</span>
							<div class="pcon">
								<span>20</span> points
							</div>
							<a href="" class="lnk">See all points</a>
						</div>
					</div>
					<h2>
							<span class="thin" ng-if="!edit">My</span>
							<span class="thin" ng-if="edit">Edit</span>
							Profile
					</h2>
					<hr />
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ut erat a erat vehicula pulvinar.
						Vivamus vitae justo consectetur, molestie justo ut, suscipit nibh. Pellentesque accumsan elit.
					</p>
				</div>
			</div>
			<div class="form-content col-md-12">
				<div class="alert alert-danger" ng-if="error">
                    <p>{! error !}</p>
                </div>
                <div class="alert alert-success" ng-if="success">
                	<p>{! success_msg !}</p>
                </div>
				<form class="form-horizontal" name="form_profile" id="form_profile">
					<fieldset>
						<legend>Credentials Information</legend>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">Username <span class="required">*</span></label>
	                        <div class="col-md-5">
	                            <input ng-disabled="!edit" type="text" class="form-control" ng-model="prof.username" name="username" placeholder="Username" 
	                            ng-model-options="{debounce : {'default' : 1000}}" ng-change="checkAvailability(prof.username)" required />
	                        </div>
	                        <div style="margin-top: 7px;"> 
	                            <i ng-if="u_loading" class="fa fa-spinner fa-spin"></i>
	                            <i ng-if="u_success" class="fa fa-check success-color"></i>
	                            <span ng-if="u_error" class="error-msg-con"> Username is invalid or already exist</span>
	                        </div>
	                    </div>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">Email <span class="required">*</span></label>
	                        <div class="col-md-5">
	                            <input ng-disabled="!edit" type="text" class="form-control" ng-model="prof.email" name="email" placeholder="Email Address"
	                                ng-model-options="{debounce : {'default' : 1000}}" ng-change="checkEmailAvailability(prof.email)" required />
	                        </div>
	                        <div style="margin-top: 7px;">
	                            <i ng-if="e_loading" class="fa fa-spinner fa-spin"></i>
	                            <i ng-if="e_success" class="fa fa-check success-color"></i>
	                            <span ng-if="e_error" class="error-msg-con"> Email Address is invalid or already exist</span>
	                        </div>
	                    </div>
					</fieldset>
					<fieldset>
						<legend>Personal Information</legend>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">First Name <span class="required">*</span></label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-disabled="!edit" ng-model="prof.first_name">
	                        </div>
	                    </div>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">Last Name <span class="required">*</span></label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-disabled="!edit" ng-model="prof.last_name">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">Gender <span class="required">*</span></label>
	                        <div class="col-md-5">
	                            {!! Form::select('', array('Male' => 'Male', 'Female' => 'Female'), 'prof.gender',array('class' => 'form-control', 'ng-model' => 'prof.gender', 'ng-disabled' => '!edit')); !!}
	                        </div>
	                    </div>  
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">Birthday <span class="required">*</span></label>
	                        <div class="col-md-5">
	                            <div class="dropdown">
	                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
	                                <div class="input-group">
	                                    <input disabled="disabled" type="text" id="birth_date" class="form-control" value="{! prof.birth | date:'yyyy-MM-dd' !}">
	                                    <input type="hidden" name="birth_date" value="{! prof.birth | date:'yyyyMMdd' !}">
	                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                </div>
	                              </a>
	                              <ul ng-show="edit" class="dropdown-menu" role="menu" aria-labelledby="dLabel">
	                                <datetimepicker data-ng-model="prof.birth" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
	                              </ul>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">Age</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.age" ng-disabled="!edit">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">City <span class="required">*</span></label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.city" ng-disabled="!edit">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">State <span class="required">*</span></label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.state" ng-disabled="!edit">
	                        </div>
	                    </div>
	                    <div class="form-group" ng-init="getCountries()">
	                        <label for="" class="col-md-2 control-label">Country <span class="required">*</span></label>
	                        <div class="col-md-5">
	                            <select class="form-control" ng-model="prof.country" ng-disabled="!edit">
	                                <option selected="selected" value="">-- Select Country --</option>
	                                <option ng-repeat="country in countries" value="{! country.id !}" 
	                                	ng-selected="{! prof.country == country.id !}">{! country.name !}</option>
	                            </select>
	                        </div>
	                    </div>
					</fieldset>
					<fieldset>
						<legend>School Information</legend>
						<div class="form-group" ng-if="prof.school_name">
	                        <label for="" class="col-md-2 control-label">School Name</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.school_name" ng-disabled="!edit">
	                        </div>
	                    </div>
						<div class="form-group" ng-init="getGradeLevel()">
                        <label for="" class="col-md-2 control-label">School level <span class="required">*</span></label>

                        <div class="col-md-5 nullable">
                            <select class="form-control" ng-model="prof.grade_code" ng-disabled="!edit">
                                <option value="">-- Select Level --</option>
                                <option ng-selected="{! prof.grade_code == grade.code !}" ng-repeat="grade in grades" value="{! grade.code !}">{! grade.name !}</option>
                            </select>
                        </div><br><br>
                    </div>   
					</fieldset>
					<div class="form-group">
						<div class="btncon col-md-9" style="text-align:center;" ng-if="!edit">
							<a href="{!! route('student.profile.change_password')!!}" class="btn btn-red">Change Password</a>
							<a class="btn btn-purple" ng-click="editProfile()">Edit Profile</a>
						</div>
						<div class="btncon col-md-9" style="text-align:center;" ng-if="edit">
							<a class="btn btn-red" ng-click="saveProfile(prof)">Save Changes</a>
							<a class="btn btn-purple" ng-click="setActive('index')">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	
</div>
@stop

@section('footer')

@overwrite

@section('scripts')

@stop