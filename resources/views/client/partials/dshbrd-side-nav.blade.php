<div class="client-prof">
	<div class="client-title" ng-if="user.role == futureed.PRINCIPAL">
		Principal Dashboard
	</div>
	<div class="client-title" ng-if="user.role == futureed.TEACHER">
		Teacher Dashboard
	</div>
	<div class="client-title" ng-if="user.role == futureed.PARENT">
		Parent Dashboard
	</div>
	<div class="client-name">
		Welcome, {! user.first_name !}
	</div>
</div>

<div class="title-row" ng-if="profileActive">
	My Account
</div>

<ul ng-init="profile.setClientProfileActive()"  ng-if="profileActive">
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
<ul ng-if="!profileActive  && user.role == futureed.PARENT">
	<li class="client-nav" ng-class="{ 'tab-active' : student.active == 'student' }">
		<a href="{{ route('client.parent.student.index') }}"><span><i class="fa fa-user"></i></span>Student</a>
	</li>
	<li class="client-nav" ng-class="{ 'tab-active' : payment.active == 'payment' }">
		<a href="{{ route('client.parent.payment.index') }}"><span><i class="fa fa-edit"></i></span>Payment</a>
	</li>
	<li class="client-nav" ng-class="{ 'tab-active' : module.active == 'module' }">
		<a href="{{ route('client.parent.module.index') }}"><span><i class="fa fa-cubes"></i></span>Module</a>
	</li>
</ul>