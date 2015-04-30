@extends('student.app')

@section('content')
<div class="container login" ng-cloak>
    <div class="form-style register_student form-wide" ng-init="success={!! '$success' !!}" ng-show="!success"> 
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
                        <div style="margin: 7px 0px;">(<span class="required">*</span> ) Indicates a required field.</div>
                    </div>
                </div>
            </div>
            
            <div class="form-content col-md-12">
                <div class="error" ng-if="error">
                    <p>{! error !}</p>
                </div>
                <fieldset>
                    <legend>User Credentials</legend>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Username<span class="required">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.username" name="username" placeholder="Username" 
                            ng-model-options="{debounce : {'default' : 1000}}" ng-change="checkAvailability(reg.username, 'Student')" required />
                        </div>
                        <div style="margin-top: 7px;"> 
                            <i ng-if="u_loading" class="fa fa-spinner fa-spin"></i>
                            <i ng-if="u_success" class="fa fa-check success-color"></i>
                            <span ng-if="u_error" class="error-msg-con">{! u_error !}</span>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Email<span class="required">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.email" placeholder="Email Address"
                                ng-model-options="{debounce : {'default' : 1000}}" ng-change="checkEmailAvailability(reg.email, 'Student')" required />
                        </div>
                        <div style="margin-top: 7px;">
                            <i ng-if="e_loading" class="fa fa-spinner fa-spin"></i>
                            <i ng-if="e_success" class="fa fa-check success-color"></i>
                            <span ng-if="e_error" class="error-msg-con">{! e_error !}</span>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Personal Information</legend>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">First Name<span class="required">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.first_name" placeholder="First Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Last Name<span class="required">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.last_name" placeholder="Last Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Gender<span class="required">*</span></label>
                        <div class="col-md-4">
                            {!! Form::select('', array('' => '-- Select Gender --', 'male' => 'Male', 'female' => 'Female'), 'male',array('class' => 'form-control', 'ng-model' => 'reg.gender')); !!}
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">Birthday<span class="required">*</span></label>
                        <div class="col-md-4">
                            <div class="dropdown">
                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
                                <div class="input-group">
                                    <input disabled="disabled" type="text" id="birth_date" class="form-control" value="{! reg.birth | date:'yyyy-MM-dd' !}">
                                    <input type="hidden" name="birth_date" value="{! reg.birth | date:'yyyyMMdd' !}">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                              </a>
                              <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <datetimepicker data-ng-model="reg.birth" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
                              </ul>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">City<span class="required">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.city" placeholder="City" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">State<span class="required">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.state" placeholder="State" required />
                        </div>
                    </div>
                    <div class="form-group" ng-init="getCountries()">
                        <label for="" class="col-md-2 control-label">Country<span class="required">*</span></label>
                        <div class="col-md-4">
                            <select class="form-control" ng-model="reg.country">
                                <option value="">-- Select Country --</option>
                                <option ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>School Information</legend>
                    <div class="form-group" ng-if="invited">
                        <label for="" class="col-md-2 control-label">School Name<span class="required">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" ng-model="reg.school_code" disabled="disabled" value="N/A" required />
                        </div>
                    </div>
                    <div class="form-group" ng-init="getGradeLevel()">
                        <label for="" class="col-md-2 control-label">School level<span class="required">*</span></label>

                        <div class="col-md-4 nullable">
                            <select class="form-control" ng-model="reg.grade_code">
                                <option value="">-- Select Level --</option>
                                <option ng-repeat="grade in grades" value="{! grade.code !}">{! grade.name !}</option>
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
                                I agree on the <a href="#" data-toggle="modal" ng-click="showModal('terms_modal')">Terms and Conditions</a> and <a href="#" ng-click="showModal('policy_modal')">Data Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    <div class="btn-container col-sm-6 col-sm-offset-3">
                        <a ng-click="validateRegistration(reg, terms)" class="btn btn-red btn-medium">REGISTER</a>
                        <a href="{!! route('student.login') !!}" class="btn btn-purple btn-medium">Cancel</a>
                    </div>
                </fieldset>
            </div>
        </form>
    </div>

    @include('student.login.registration-success')
    @include('student.login.terms-and-condition')
    @include('student.login.privacy-policy')
</div>
@stop

@section('footer')
  @parent
@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop