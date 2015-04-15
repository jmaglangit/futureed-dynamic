@extends('student.app')

@section('content')
<div class="container login follow-up-reg" ng-init="getUserDetails()">

    <div class="form-style register_student form-wide"> 
    	<form class="form-horizontal" name="followUpRegistrationForm">
            <div class="form-header">
                <div class="media">

                </div>
            </div>
            <div class="form-content">
            	<h3>Pick An Avatar for your Profile</h3>

            	<p><button type="button" class="btn btn-red" ng-click="validatePassword()">Save and Proceed</button></p>
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