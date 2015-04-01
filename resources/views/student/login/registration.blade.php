@extends('student.app')

@section('content')
<div class="container login">
    <div class="form-style register_student form-wide"> 
        <div class="row">

            <div class="form-header">
                <div class="media">
                    <div class="media-left">
                        {!! Html::image('images/user_principal.jpg') !!}
                    </div>
                    <div class="media-body media-middle">
                        <h2 class="box-title"><span class="thin">Student</span> Registration</h2>
                    </div>
                </div>
            </div>
            <div class="form-content col-md-12" id="form_registration">
                <form class="form-horizontal">
                    <fieldset>
                        <legend>Personal Information</legend>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">First Name</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="Maggie">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Last Name</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="Simpson">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Gender</label>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option value="">Male</option>
                                    <option value="" selected="selected">Female</option>
                                </select>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Birthday</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control">
                            </div>
                        </div> 
                    </fieldset>
                    <fieldset>
                        <legend>User Credentials</legend>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Email</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="maggie@simpsons.com">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Username</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="maggie9">
                            </div>
                        </div> 
                    </fieldset>
                    <fieldset>
                        <legend>School Information</legend>
                        <div class="form-group" id="form_schoolname">
                            <label for="" class="col-md-2 control-label">School Name</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="Spring Field Elementary">
                            </div>
                        </div>
                        <div class="form-group" id="form_address">
                            <label for="" class="col-md-2 control-label">Grade</label>

                            <div class="col-md-4">
                            <select name="" id="" class="form-control">
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
                                        <input type="checkbox" value="">
                                        I agree on the <a href="#">Terms and Conditions</a>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4">
                                    <div class="form-group">
                                        <a href="#" class="btn btn-red">REGISTER</a>
                                    </div>    
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
  @parent
@overwrite

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop