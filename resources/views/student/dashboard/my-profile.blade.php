@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
<div class="container dshbrd-con" ng-init="getUserDetails()">
	<div class="wrapr"> 
		<div class="side-nav">
			@include('student.partials.dshbrd-side-nav')
		</div>
		<div class="content">
			<div class="hdr">
				<div class="avtrcon">
					{!! Html::image('images/password/img-pass-03.jpg') !!}
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
					<h1>My <span>Profile</span></h1>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ut erat a erat vehicula pulvinar.
						Vivamus vitae justo consectetur, molestie justo ut, suscipit nibh. Pellentesque accumsan elit.
					</p>
				</div>
			</div>
			<div class="form-content col-md-12">
				<form class="form-horizontal" name="form_profile">
					<fieldset>
						<legend>Personal Information</legend>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">First Name</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.first_name">
	                        </div>
	                    </div>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">Last Name</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.last_name">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">Gender</label>
	                        <div class="col-md-5">
	                            {!! Form::select('level', array('male' => 'Male', 'female' => 'Female'), 'male',array('class' => 'form-control', 'ng-model' => 'prof.gender')); !!}
	                        </div>
	                    </div>  
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">Birthday</label>
	                        <div class="col-md-5">
	                            <div class="dropdown">
	                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
	                                <div class="input-group">
	                                    <input disabled="disabled" type="text" class="form-control" name="birthday" value="{! prof.birthday | date:'yyyy-MM-dd' !}">
	                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                </div>
	                              </a>
	                              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
	                                <datetimepicker data-ng-model="prof.birthday" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
	                              </ul>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">Age</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.age">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">City</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.city">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">State</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.state">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="" class="col-md-2 control-label">Country</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.country">
	                        </div>
	                    </div>
					</fieldset>
					<fieldset>
						<legend>Credentials Information</legend>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">Email</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.email">
	                        </div>
	                    </div>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">Username</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.username">
	                        </div>
	                    </div>
					</fieldset>
					<fieldset>
						<legend>School Information</legend>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">School Name</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.school_name">
	                        </div>
	                    </div>
						<div class="form-group">
	                        <label for="" class="col-md-2 control-label">School Level</label>
	                        <div class="col-md-5">
	                            <input type="text" class="form-control" ng-model="prof.last_name">
	                        </div>
	                    </div>
					</fieldset>
					<div class="form-group">
						<div class="btncon col-md-10 col-md-offset-2">
							<a class="btn btn-red">Change Password</a>
							<a class="btn btn-purple">Edit Profile</a>
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