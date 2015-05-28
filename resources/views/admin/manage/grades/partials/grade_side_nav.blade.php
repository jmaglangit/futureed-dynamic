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

    <ul id="menu-content" class="nav-list">
        <li id="client_nav_head" data-target="client" class="side-nav-li">
			<a href="{!! route('admin.manage.subject.index')!!}" class="nav-link">Subject</a>
		</li>               
    </ul>

     <ul id="menu-content" class="nav-list" ng-init="grade.setManageGradeActive()">
        <li id="grade_nav_head" data-target="grade" class="active side-nav-li">
			<a href="" class="nav-link">Grades</a>
		</li>
		<ul class="sub-menu" id="grade">
        	<li ng-class="{ 'active' : grade.active_add_grade }">
				<a href="" ng-click="grade.setManageGradeActive('add_grade')"><span><i class="fa fa-plus-square"></i></span>Add Grade</a>
			</li>
			<li ng-class="{ 'active' : grade.active_list_grade }">
				<a href="" ng-click="grade.setManageGradeActive()"><span><i class="fa fa-list-alt"></i></span>View Grade List</a>
			</li>
        </ul>                 
    </ul>
</div>
