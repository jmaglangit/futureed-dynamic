@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
<div class="container dshbrd-con" ng-init="getUserDetails()" ng-cloak>
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
				<form class="form-horizontal" name="form_profile" ng-init="view=true">
					<fieldset>
						<legend>Personal Information</legend>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">First Name</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-disabled="!edit" ng-model="prof.first_name">
	                        </div>
	                    </div>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">Last Name</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-disabled="!edit" ng-model="prof.last_name">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">Gender</label>
	                        <div class="col-md-5">
	                            {!! Form::select('', array('Male' => 'Male', 'Female' => 'Female'), 'prof.gender',array('class' => 'form-control', 'ng-model' => 'prof.gender', 'ng-disabled' => '!edit')); !!}
	                        </div>
	                    </div>  
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">Birthday</label>
	                        <div class="col-md-5">
	                            <div class="dropdown">
	                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
	                                <div class="input-group">
	                                    <input disabled="disabled" type="text" class="form-control" value="{! prof.birth_date | date:'yyyy-MM-dd' !}">
	                                    <input type="hidden" name="birth_date" value="{! prof.birth_date | date:'yyyyMMdd' !}">
	                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                </div>
	                              </a>
	                              <ul ng-show="edit" class="dropdown-menu" role="menu" aria-labelledby="dLabel">
	                                <datetimepicker data-ng-model="prof.birth_date" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
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
	                        <label for="" class="col-md-2 control-label">City</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.city" ng-disabled="!edit">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">State</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.state" ng-disabled="!edit">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">Country</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.country" ng-disabled="!edit">
	                        </div>
	                    </div>
					</fieldset>
					<fieldset>
						<legend>Credentials Information</legend>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">Email</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.email" ng-disabled="!edit">
	                        </div>
	                    </div>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">Username</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.username" ng-disabled="!edit">
	                        </div>
	                    </div>
					</fieldset>
					<fieldset>
						<legend>School Information</legend>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">School Name</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.school_name" ng-disabled="!edit">
	                        </div>
	                    </div>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">School Level</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.last_name" ng-disabled="!edit">
	                        </div>
	                    </div>
					</fieldset>
					<div class="form-group">
						<div class="btncon col-md-10 col-md-offset-2" ng-if="!edit">
							<a href="{!! route('student.profile.change_password')!!}" class="btn btn-red">Change Password</a>
							<a class="btn btn-purple" ng-click="editProfile()">Edit Profile</a>
						</div>
						<div class="btncon col-md-9" style="text-align:center;" ng-if="edit">
							<a class="btn btn-red" ng-click="saveProfile()">Save Changes</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<textarea id="userdata" name="hide" style="display:none;">{!! Session::get('user') !!}</textarea>
</div>
@stop

@section('footer')

@overwrite

@section('scripts')

@stop