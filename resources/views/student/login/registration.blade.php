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
                            <input type="text" class="form-control" ng-model="reg.first_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Last Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.last_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Gender</label>
                        <div class="col-md-4">
                            {!! Form::select('level', array('male' => 'Male', 'female' => 'Female'), 'male',array('class' => 'form-control', 'ng-model' => 'reg.gender')); !!}
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Birthday</label>
                        <div class="col-md-4">
                            <div class="dropdown">
                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
                                <div class="input-group">
                                    <input disabled="disabled" type="text" class="form-control" name="birthday" value="{! reg.birthday | date:'yyyy-MM-dd' !}">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                              </a>
                              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <datetimepicker data-ng-model="reg.birthday" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
                              </ul>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">City</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.city">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">State</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.state">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Country</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.country">
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>User Credentials</legend>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Email</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.email">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Username</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.username">
                        </div>
                    </div> 
                </fieldset>
                <fieldset>
                    <legend>School Information</legend>
                    <div class="form-group" id="form_schoolname">
                        <label for="" class="col-md-2 control-label">School Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.school_code">
                        </div>
                    </div>
                    <div class="form-group" id="form_address">
                        <label for="" class="col-md-2 control-label">School level</label>

                        <div class="col-md-4">
                        {!! Form::select('level', array('K2' => 'K2', 'Grade 1' => 'Grade 1', 'Grade 2' => 'Grade 2', 'Grade 3' => 'Grade 3', 'Grade 4' => 'Grade 4', 'Grade 5' => 'Grade 5', 'Grade 6' => 'Grade 6', 'Grade 7' => 'Grade 7', 'Grade 8' => 'Grade 8'), 'K2',array('class' => 'form-control', 'ng-model' => 'reg.grade_code')); !!}

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