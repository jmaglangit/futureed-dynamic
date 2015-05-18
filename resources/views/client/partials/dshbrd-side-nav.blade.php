<div class="client-prof">
	<div class="client-title" ng-if="profile.is_principal">
		Principal Dashboard
	</div>
	<div class="client-title" ng-if="profile.is_teacher">
		Teacher Dashboard
	</div>
	<div class="client-title" ng-if="profile.is_parent">
		Parent Dashboard
	</div>
	<div class="client-name">
		Welcome, {! user.first_name !}
	</div>
</div>

<div class="title-row">
	My Account
</div>

<ul ng-init="profile.setClientProfileActive('{!! $active !!}')">
	<li ng-class="{ 'active' : profile.active_index || profile.active_edit_email || profile.active_confirm_email }">
		<a href="" ng-click="profile.setClientProfileActive('index')"><span><i class="fa fa-book"></i></span>View Client Account Profile</a>
	</li>
	<li ng-class="{ 'active' : profile.active_edit }">
		<a href="" ng-click="profile.setClientProfileActive('edit')"><span><i class="fa fa-edit"></i></span>Edit Client Account Profile</a>
	</li>
	<li ng-class="{ 'active' : profile.active_password }">
		<a href="" ng-click="profile.setClientProfileActive('password')"><span><i class="fa fa-lock"></i></span>Change Password</a>
	</li>
</ul>