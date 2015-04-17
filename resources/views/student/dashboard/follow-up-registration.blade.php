@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
<div class="container login follow-up-reg" ng-init="getUserDetails()">
    <div class="form-style form-wide" ng-if="!done"> 
    	<form class="form-horizontal" name="followUpRegistrationForm">
            <div class="form-header">
                <div class="lmtcontain">

                    <div class="steps two">
                        <ul class="items">
                            <li ng-class="{active : !has_avatar}">
                                <div class="rnd-identifier" ng-click="stepOne()"></div>
                                <span>Step 1</span>
                            </li>
                            <li ng-class="{active : has_avatar}">
                                <div class="rnd-identifier" ng-click="stepTwo()"></div>
                                <span>Step 2</span>
                                <div class="pbar"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="error" ng-if="error">
                  <p>{! error !}</p>
                </div>
                <div class="lmtcontain form-group" ng-if="!has_avatar">
                	<h3>Pick an Avatar for your Profile</h3>
                    <div class="avatar-selection">
                        <div class="col-md-8 col-md-offset-2" ng-init="getAvatarImages()">
                            <ul class="avatar_list list-unstyled list-inline" >
                                <li ng-repeat="avatar in avatars" ng-click="highlight($event)">
                                    <img ng-src="{! avatar.url !}" alt="{! avatar.name !}" class="img-responsive">
                                    <input type="hidden" id="avatar_id" name="avatar_id" value="{! avatar.id !}">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="btmcon form-group">
                	   <button type="button" class="btn btn-red" ng-click="selectAvatar()">Save and Proceed</button>
                    </div>
                </div>

                <div class="lmtcontain form-group" ng-if="has_avatar">
                    <h3>Learning Style Quiz</h3>
                    <div class="avatar-selection">
                        <p><strong>This quiz aims to get what is your learning style so that you wll have a better understanding on how you learn.</strong> </p>

                        
 
                        <br /> Are you ready? Click on the next button to start.
                    </div>
                    <div class="btmcon form-group">
                       <button type="button" class="btn btn-red" ng-click="close()">NEXT</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <textarea id="userdata" name="hide" style="display:none;">{!! Session::get('user') !!}</textarea>
</div>
@stop

@section('footer')

@overwrite

@section('scripts')

@stop