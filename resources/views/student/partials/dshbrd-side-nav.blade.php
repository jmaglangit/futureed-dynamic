<ul ng-init="profile.setStudentProfileActive()">
	<li class="active">
		<a href="{!! route('student.dashboard.index') !!}">
			<i class="fa fa-arrow-left"></i> Back to Dashboard</a>
	</li>

	<li ng-class="{ 'active' : profile.active_index || profile.active_edit_email || profile.active_confirm_email}">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('index')">My Profile</a>
	</li>

	<li ng-class="{ 'active' : profile.active_edit }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('edit')">Edit Profile</a>
	</li>

	<li ng-class="{ 'active' : profile.active_rewards }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('rewards')">Student Rewards</a>
	</li>

	<li ng-class="{ 'active' : profile.active_avatar }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('avatar')">Change Avatar</a>
	</li>

	<li ng-if="!user.media_login" ng-class="{ 'active' : profile.active_password }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('password')">Change Picture Password</a>
	</li>

	<li ng-class="{ 'active' : profile.active_reports }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive('reports')"> Reports </a>
	</li>
</ul>