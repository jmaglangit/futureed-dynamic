@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
<div class="container login follow-up-reg" ng-init="getUserDetails()">
    <div class="form-style form-wide"> 
    	<form class="form-horizontal" name="followUpRegistrationForm">
            <div class="form-header">
                <div class="lmtcontain">

                    <div class="steps two">
                        <ul class="items">
                            <li class="active">
                                <div class="rnd-identifier"></div>
                                <span>Step 1</span>
                            </li>
                            <li>
                                <div class="rnd-identifier"></div>
                                <span>Step 2</span>
                                <div class="pbar"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form-content">
                <div class="lmtcontain">
                	<h3>Pick an Avatar for your Profile</h3>
                    <div class="avatar-selection">
                        <div class="col-md-4">
                            <!-- <img ng-src="{! item.password_image_file !}" alt="{! item.name !}" class="img-responsive"> -->
                        </div>
                    </div>
                    <div class="btmcon">
                	   <button type="button" class="btn btn-red" ng-click="validatePassword()">Save and Proceed</button>
                    </div>
                </div>
            </div>
			<textarea id="userdata" name="hide" style="display:none;">{!! Session::get('user') !!}</textarea>
        </form>
    </div>
</div>
@stop

@section('footer')

@overwrite

@section('scripts')

@stop