@extends('student.app')

@section('content')
<div class="container login" ng-cloak>
    <div class="form-style form-wide" ng-if="!done"> 
    	<form class="form-horizontal" name="followup_registration_form">
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
                <div ng-if="!has_avatar">
                    <div class="lmtcontain form-select-password form-group">
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
                                  <li class="item avtrcon" ng-repeat="avatar in avatars" ng-click="highlightAvatar($event)">
                                     <img ng-src="{! avatar.url !}" alt="{! avatar.name !}">
                                     <input type="hidden" id="avatar_id" name="avatar_id" value="{! avatar.id !}">
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </form>
                        </div>
                    </div>
                    <div class="btmcon">
                        <button type="button" ng-if="enable" class="btn btn-maroon btn-medium" ng-click="$parent.selectAvatar()">Proceed</button>
                    </div>
                </div>
                <div class="lmtcontain form-group" ng-if="has_avatar">
                    <h3>Learning Style Quiz</h3>

                    <div template-directive template-url="{!! route('student.learning-style.index') !!}"></div>
                    
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('scripts')
    {!! Html::script('/js/student/helpers/test.js')!!}
    {!! Html::script('/js/student/controllers/learning_style_controller.js')!!}
    {!! Html::script('/js/student/services/learning_style_service.js')!!}
@stop