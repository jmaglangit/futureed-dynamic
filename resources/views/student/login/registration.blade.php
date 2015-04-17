@extends('student.app')

@section('content')
<div class="container login">
    <div class="form-style register_student form-wide" ng-init="success=false" ng-if="!success"> 
        <form class="form-horizontal simple-form" name="form_registration" id="form_registation">
            <div class="form-header">
                <div class="media">
                    <div class="media-left">
                        {!! Html::image('images/user_parent.jpg') !!}
                    </div>
                    <div class="media-body">
                        <h2 class="box-title"><span class="thin">Student</span> Registration</h2>
                        <div class="info-box rd col-md-6">
                            <h4>For Student below 13 years old</h4>
                            <p>Parents should be the one to register, please <a href="#">Click here</a> to register.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-content col-md-12">
                <div class="error" ng-if="error">
                    <p>{! error !}</p>
                </div>

                <fieldset>
                    <legend>Personal Information</legend>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">First Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.first_name" placeholder="First Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Last Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.last_name" placeholder="Last Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Gender</label>
                        <div class="col-md-4">
                            {!! Form::select('', array('' => '-- Select Gender --', 'male' => 'Male', 'female' => 'Female'), 'male',array('class' => 'form-control', 'ng-model' => 'reg.gender')); !!}
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Birthday</label>
                        <div class="col-md-4">
                            <div class="dropdown">
                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
                                <div class="input-group">
                                    <input disabled="disabled" type="text" class="form-control" name="birth_date" value="{! reg.birth_date | date:'yyyy-MM-dd' !}">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                              </a>
                              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <datetimepicker data-ng-model="reg.birth_date" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
                              </ul>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">City</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.city" placeholder="City" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">State</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.state" placeholder="State" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Country</label>
                        <div class="col-md-4">
                            <select class="form-control" ng-model="reg.country">
                                <option value="">-- Select Country --</option>
                                <option value="Philippines" label="Philippines"></option>
                                <option value="Singapore" label="Singapore"></option>
                                <option value="United States" label="United States"></option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>User Credentials</legend>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Email</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.email" placeholder="Email Address" required />
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Username</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.username" placeholder="Username" required />
                        </div>
                    </div> 
                </fieldset>
                <fieldset>
                    <legend>School Information</legend>
                    <div class="form-group" id="form_schoolname">
                        <label for="" class="col-md-2 control-label">School Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.school_code" required />
                        </div>
                    </div>
                    <div class="form-group" ng-init="getGradeLevel()">
                        <label for="" class="col-md-2 control-label">School level</label>

                        <div class="col-md-4 nullable">
                            <select class="form-control" ng-model="reg.grade_code">
                                <option value="">-- Select Level --</option>
                                <option ng-repeat="grade in grades" value="{! grade.id !}" label="{! grade.name !}"></option>
                            </select>
                        </div><br><br>
                    </div>    
                </fieldset> 
            </div>
            <div class="block_bottom">
                <fieldset>
                    <div class="form-group">
                        <div class="checkbox text-center">
                            <label>
                                <input type="checkbox" ng-model="terms">
                                I agree on the <a href="#">Terms and Conditions</a> and <a href="#">Data Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4">
                            <div class="form-group">
                                <a ng-click="validateRegistration(reg, terms)" class="btn btn-red">REGISTER</a>
                            </div>    
                        </div>
                    </div>
                </fieldset>
            </div>
        </form>
    </div>

    @include('student.login.registration-success')
</div>
@stop

@section('footer')
  @parent
@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop