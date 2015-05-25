<div class="client-prof">
	<div class="client-title">
		Admin Dashboard
	</div>
	<div class="client-name">
		Welcome, {! user.first_name !}
	</div>
</div>

<div class="nav-menu">
    <ul id="menu-content" class="nav-list">
        <li id="client_nav_head" data-target="client" class="side-nav-li">
			<a href="{!! route('admin.manage.client.index')!!}" class="nav-link">Client</a>
		</li>               
    </ul>

     <ul id="menu-content" class="nav-list" ng-init="subject.setManageSubjectActive()">
        <li id="subject_nav_head" data-target="subject" class="active side-nav-li">
			<a href="" class="nav-link">Subject</a>
		</li>
		<ul class="sub-menu collapse" id="subject">
        	<li ng-class="{ 'active' : subject.active_add_subject }">
				<a href="" ng-click="subject.setManageSubjectActive('add_subject')"><span><i class="fa fa-plus-square"></i></span>Add Subject</a>
			</li>
			<li ng-class="{ 'active' : subject.active_list_subject }">
				<a href="" ng-click="subject.setManageSubjectActive()"><span><i class="fa fa-list-alt"></i></span>View Subject List</a>
			</li>
        </ul>                 
    </ul>
</div>
