<div class="client-prof">
	<div class="client-title">
		Admin Dashboard
	</div>
	<div class="client-name">
		Welcome, Seymour
	</div>
</div>

<div class="nav-menu">

    <ul id="menu-content" class="nav-list" ng-init="client.setManageClientActive()">
        <li id="client_nav_head" data-target="client" ng-class="{ 'active' : admincon.active_client}" class="side-nav-li">
			<a href="" class="nav-link">Client</a>
		</li>
		<ul class="sub-menu collapse" id="client">
        	<li ng-class="{ 'active' : client.active_index }">
				<a href="" ng-click="client.setManageClientActive('add_client')"><span><i class="fa fa-plus-square"></i></span>Add Client</a>
			</li>
			<li ng-class="{ 'active' : client.active_edit }">
				<a href="" ng-click="client.setManageClientActive()"><span><i class="fa fa-list-alt"></i></span>View Client List</a>
			</li>
        </ul>
        <li  data-toggle="collapse" data-target="#students" class="collapsed side-nav-li" ng-class="{ 'active' : admincon.active_student}">
          <a class="nav-link" ng-click="admincon.setActiveAdmin('student')" href="">
                    Student
        	</a>
        </li>
        <ul class="sub-menu collapse" id="students">
        	<li>
				<a href="">
					<span><i class="fa fa-plus-square"></i></span>
					Add Student
				</a>
			</li>
			<li>
				<a href=""><span><i class="fa fa-list-alt"></i></span>View Student List</a>
			</li>
        </ul>
        <li data-toggle="collapse" data-target="#price" class="collapsed side-nav-li" ng-class="{'active' : admincon.active_price}">
          <a class="dropdown-toggle nav-link">Price Management <span class="caret"></span></a>
        </li>  
        <ul class="sub-menu collapse" id="price">
          <li ng-class="{'active' : admincon.active_price}" class="side-nav-li">
          	<a href="#" ng-click="admincon.setActiveAdmin('price')"><span><i class="fa fa-dollar"></i>Price Settings</span></a>
          </li>
        </ul>
         <li data-toggle="collapse" data-target="#master" class="collapsed side-nav-li" ng-class="{'active' : admincon.active_announcement}">
          <a class="dropdown-toggle nav-link">Master Settings <span class="caret"></span></a>
        </li>  
        <ul class="sub-menu collapse" id="master">
          <li ng-class="{'active' : admincon.active_announcement}" class="side-nav-li">
          	<a href="#" ng-click="admincon.setActiveAdmin('announcement')"><span><i class="fa fa-bullhorn"></i>announcement</span></a>
          </li>
        </ul>                 
    </ul>
</div>
