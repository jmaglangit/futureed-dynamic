<div class="client-prof">
	<div class="client-title">
		Admin Dashboard
	</div>
	<div class="client-name">
		Welcome, Seymour
	</div>
</div>

<div>
	<ul class="nav-list" ng-init="admincon.setActiveAdmin('{!! $active !!}')">
		<li ng-class="{ 'active' : admincon.active_client}">
			<a href="#" class="nav-link" ng-click="admincon.setActiveAdmin('client')">Client</a>
		</li>
		<li ng-class="{'active' : admincon.active_student}">
			<a href="#" class="nav-link" ng-click="admincon.setActiveAdmin('student')">Student</a>
		</li>
	</ul>
</div>
<div class="row-admin">
	<ul ng-init="">
		<li ng-class="{ 'active' : profile.active_index }">
			<a href="" ng-click="profile.setClientProfileActive('index')"><span><i class="fa fa-plus-square"></i></span>Add Student</a>
		</li>
		<li ng-class="{ 'active' : profile.active_edit }">
			<a href="" ng-click="profile.setClientProfileActive('edit')"><span><i class="fa fa-list-alt"></i></span>View Student List</a>
		</li>
		<li ng-class="{ 'active' : profile.active_password }">
			<a href="" ng-click="profile.setClientProfileActive('password')"><span><i class="fa fa-trophy"></i></span>Student Rewards</a>
		</li>
	</ul>
</div>