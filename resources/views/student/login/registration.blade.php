@extends('student.app')

@section('content')
<div class="container login">
    <div class="form-style register_student form-wide"> 
        <form class="form-horizontal" name="registrationForm">
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
            <div class="form-content col-md-12" id="form_registration">
                
                <fieldset>
                    <legend>Personal Information</legend>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">First Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.firstName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Last Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.lastName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Gender</label>
                        <div class="col-md-4">
                            <select class="form-control" ng-model="reg.gender">
                                <option value="male" selected="selected">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Birthday</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" ng-model="reg.birthdate">
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
                            <input type="text" class="form-control" ng-model="reg.school">
                        </div>
                    </div>
                    <div class="form-group" id="form_address">
                        <label for="" class="col-md-2 control-label">Grade</label>

                        <div class="col-md-4">
                        <select name="" id="" class="form-control" ng-model="reg.grade">
                            <option value="" selected="selected">K1</option>
                            <option value="">K2</option>
                            <option value="">Grade 1</option>
                            <option value="">Grade 2</option>
                            <option value="">Grade 3</option>
                            <option value="">Grade 4</option>
                            <option value="">Grade 5</option>
                            <option value="">Grade 6</option>
                            <option value="">Grade 7</option>
                            <option value="">Grade 8</option>
                        </select>

                        </div><br><br>
                    </div>    
                </fieldset>
                <div class="block_bottom">
                    <fieldset>
                        <div class="form-group">
                            <div class="checkbox text-center">
                                <label>
                                    <input type="checkbox" ng-model="reg.terms">
                                    I agree on the <a href="#">Terms and Conditions</a>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4">
                                <div class="form-group">
                                    <a ng-click="validateRegistration(reg)" class="btn btn-red">REGISTER</a>
                                </div>    
                            </div>
                        </div>
                    </fieldset>
                </div>
                
            </div>
        </form>
    </div>
</div>
@stop

@section('footer')
  @parent
@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop