<ul ng-init="profile.setStudentProfileActive()">
	<li class="active">
		<a href="{!! route('student.dashboard.index') !!}" ng-click="profile.setStudentProfileActive('index')">
			<i class="fa fa-arrow-left"></i> Back to Dashboard</a>
	</li>

	<li ng-class="{ 'active' : profile.active_index || profile.active_edit_email || profile.active_confirm_email}">
		<a href="" ng-click="profile.setStudentProfileActive('index')">My Profile</a>
	</li>

	<li ng-class="{ 'active' : profile.active_edit }">
		<a href="" ng-click="profile.setStudentProfileActive('edit')">Edit Profile</a>
	</li>

	<li ng-class="{ 'active' : profile.active_rewards }">
		<a href="" ng-click="profile.setStudentProfileActive('rewards')">Student Rewards</a>
	</li>

	<li ng-class="{ 'active' : profile.active_avatar }">
		<a href="" ng-click="profile.setStudentProfileActive('avatar')">Change Avatar</a>
	</li>

	<li ng-class="{ 'active' : profile.active_password }">
		<a href="" ng-click="profile.setStudentProfileActive('password')">Change Picture Password</a>
	</li>
</ul>