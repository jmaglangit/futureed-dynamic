<div class="client-prof">
	<div class="client-title">
		Principal Dashboard
	</div>
	<div class="client-name">
		Welcome, {! profile.prof.first_name !}
	</div>
</div>
<div class="title-row">
	My Account
</div>
<ul ng-init="profile.setClientProfileActive('{!! $active !!}')">
	<li ng-class="{ 'active' : profile.active_index }">
		<a href="" ng-click="profile.setClientProfileActive('index')"><span><i class="fa fa-book"></i></span>View Client Account Profile</a>
	</li>
	<li ng-class="{ 'active' : profile.active_edit }">
		<a href="" ng-click="profile.setClientProfileActive('edit')"><span><i class="fa fa-edit"></i></span>Edit Client Account Profile</a>
	</li>
	<li ng-class="{ 'active' : profile.active_password }">
		<a href="" ng-click="profile.setClientProfileActive('password')"><span><i class="fa fa-lock"></i></span>Change Password</a>
	</li>
</ul>