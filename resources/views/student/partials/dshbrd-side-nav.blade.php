<ul ng-init="profile.setStudentProfileActive()">
	<li class="active">
		<a href="{!! route('student.dashboard.index') !!}">
			<i class="fa fa-arrow-left"></i> {!! trans('messages.back_to_dashboard') !!}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_index || profile.active_edit_email || profile.active_confirm_email}">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('index')">{!! trans('messages.my_profile') !!}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_edit }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('edit')">{!! trans('messages.edit_profile') !!}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_rewards }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('rewards')">{!! trans('messages.student_rewards') !!}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_avatar_accessory }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('avatar_accessory')">{!! trans('messages.avatar_accessories') !!}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_avatar }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('avatar')">{!! trans('messages.change_avatar') !!}</a>
	</li>

	<li ng-if="!user.media_login" ng-class="{ 'active' : profile.active_password }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('password')">{!! trans('messages.student_change_picture_password') !!}</a>
	</li>

	<li ng-if="!user.media_login" ng-class="{ 'active' : profile.settings }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('settings')">Settings</a>
	</li>
</ul>