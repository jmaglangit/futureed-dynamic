<ul ng-init="setActive('{!! $active !!}')">
	<li ng-if="!edit" ng-class="{ 'active' : active_index }"><a href="{!! route('student.profile.index') !!}">My Profile</a></li>
	<li ng-if="edit" ng-class="{ 'active' : active_index }"><a href="{!! route('student.profile.index') !!}">Edit Profile</a></li>
	<li ng-class="{ 'active' : active_rewards }"><a href="{!! route('student.profile.rewards') !!}">Student Rewards</a></li>
	<li ng-class="{ 'active' : active_avatar }"><a href="{!! route('student.profile.change_avatar') !!}">Change Avatar</a></li>
	<li ng-class="{ 'active' : active_password }"><a href="{!! route('student.profile.change_password') !!}">Change Picture Password</a></li>
</ul>