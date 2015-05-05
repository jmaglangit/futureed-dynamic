@extends('student.app')

@section('content')
<div class="container login follow-up-reg" ng-cloak>
    <div class="form-style form-wide" ng-if="!done"> 
    	<form class="form-horizontal" name="followUpRegistrationForm">
            <div class="form-header">
                <div class="lmtcontain">
                    <div class="steps two">
                        <ul class="items">
                            <li ng-class="{active : !has_avatar}">
                                <div class="rnd-identifier"></div>
                                <span>Step 1</span>
                            </li>
                            <li ng-class="{active : has_avatar}">
                                <div class="rnd-identifier"></div>
                                <span>Step 2</span>
                                <div class="pbar"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="lmtcontain form-group" ng-if="!has_avatar">
                    <h3>Pick an Avatar for your Profile</h3>
                    <div class="alert alert-danger" ng-if="errors">
                        <p ng-repeat="error in errors" > 
                          {! error !}
                        </p>
                    </div>
                    <div ng-if="!has_avatar">
                      <form id="change_avatar_form">
                        <div class="form-select-password">
                          <div id="title" class="title"></div>
                          <div class="form_content">
                            <ul class="avatar_list list-unstyled list-inline" ng-init="getAvatarImages()">
                              <li class="item avtrcon" style="width:20%" ng-repeat="avatar in avatars" ng-click="highlightAvatar($event)">
                                 <img ng-src="{! avatar.url !}" alt="{! avatar.name !}">
                                 <input type="hidden" id="avatar_id" name="avatar_id" value="{! avatar.id !}">
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="btmcon">
                            <button type="button" class="btn btn-red" ng-click="selectAvatar()">Proceed</button>
                        </div>
                      </form>
                    </div>
                </div>
                <div class="lmtcontain form-group" ng-if="has_avatar">
                    <h3>Learning Style Quiz</h3>
                    <div class="avatar-selection">
                        <p>
                            <strong>This quiz aims to get what is your learning style so that you wll have a better understanding on how you learn.</strong>
                        </p>
                        <br /> Are you ready? Click on the next button to start.
                    </div>
                    <div class="btmcon">
                       <a href="{!! route('student.dashboard.index') !!}" type="button" class="btn btn-red">NEXT</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('footer')

@overwrite

@section('scripts')

@stop