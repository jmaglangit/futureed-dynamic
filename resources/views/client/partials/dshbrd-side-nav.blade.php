<div class="client-prof">
	<div class="client-title" ng-if="!teacher && !parent && principal">
		Principal Dashboard
	</div>
	<div class="client-title" ng-if="teacher && !parent && !principal">
		Teacher Dashboard
	</div>
	<div class="client-title" ng-if="!teacher && parent && !principal">
		Parent Dashboard
	</div>
	<div class="client-name">
		Welcome, {! user.first_name !}
	</div>
</div>
<div class="title-row">
	My Account
</div>
<ul ng-init="setActive('{!! $active !!}')">
	<li ng-class="{ 'active' : active_index }"><a href="{!! route('student.profile.index') !!}"><span><i class="fa fa-book"></i></span>View Client Account Profile</a></li>
	<li ng-class="{ 'active' : active_edit }"><a href="{!! route('student.profile.index') !!}"><span><i class="fa fa-edit"></i></span>Edit Client Account Profile</a></li>
	<li ng-class="{ 'active' : active_rewards }"><a href="{!! route('student.profile.rewards') !!}"><span><i class="fa fa-lock"></i></span>Change Password</a></li>
</ul>