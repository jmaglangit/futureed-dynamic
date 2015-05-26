<div class="client-prof">
	<div class="client-title">
		Admin Dashboard
	</div>
	<div class="client-name">
		Welcome, Seymour
	</div>
</div>

<div class="nav-menu">

    <ul id="menu-content" class="nav-list">
        <li  data-toggle="collapse" data-target="#students" class="collapsed side-nav-li" ng-class="{ 'active' : admincon.active_student}">
            <a class="nav-link">
              Manage Users
            </a>
        </li>

        <ul class="sub-menu collapse" id="students">
        	<li ng-class="{ 'active' : profile.active_index }" class="side-nav-li">
				<a href="" ng-click="profile.setClientProfileActive('index')"><span><i class="fa fa-plus-square"></i></span>Add Student</a>
			</li>
			<li ng-class="{ 'active' : profile.active_edit }" class="side-nav-li">
				<a href="" ng-click="profile.setClientProfileActive('edit')"><span><i class="fa fa-list-alt"></i></span>View Student List</a>
			</li>
			<li ng-class="{ 'active' : profile.active_password }" class="side-nav-li">
				<a href="" ng-click="profile.setClientProfileActive('password')"><span><i class="fa fa-trophy"></i></span>Student Rewards</a>
			</li>
        </ul>
        <li data-toggle="collapse" data-target="#module" class="collapsed side-nav-li" ng-class="{'active' : admincon.active_module}">
          <a class="dropdown-toggle nav-link">Module Management <span class="caret"></span></a>
        </li>
        <ul class="sub-menu collapse" id="module">
          <li ng-class="{'active' : admincon.active_module}" class="side-nav-li">
            <a href="{!! route('admin.manage.price.index') !!}" ng-click="admincon.setActiveAdmin('price')"><span><i class="fa fa-book"></i>Subject</span></a>
          </li>
        </ul> 
        <li data-toggle="collapse" data-target="#price" class="collapsed side-nav-li" ng-class="{'active' : admincon.active_price}">
          <a class="dropdown-toggle nav-link">Price Management <span class="caret"></span></a>
        </li>  
        <ul class="sub-menu collapse" id="price">
          <li ng-class="{'active' : admincon.active_price}" class="side-nav-li">
          	<a href="{!! route('admin.manage.price.index') !!}" ng-click="admincon.setActiveAdmin('price')"><span><i class="fa fa-dollar"></i>Price & Discounts</span></a>
          </li>
        </ul>
         <li data-toggle="collapse" data-target="#master" class="collapsed side-nav-li" ng-class="{'active' : admincon.active_announcement}">
          <a class="dropdown-toggle nav-link">Master Settings <span class="caret"></span></a>
        </li>  
        <ul class="sub-menu collapse" id="master">
          <li ng-class="{'active' : admincon.active_announcement}" class="side-nav-li">
          	<a href="{!! route('admin.manage.announce.index') !!}" ng-click="admincon.setActiveAdmin('announcement')"><span><i class="fa fa-bullhorn"></i>announcement</span></a>
        	<!-- <li>
				    <a href="#"> Admin </a>
	        </li> -->
          <li>
            <a href="{!! route('admin.manage.client.index') !!}"> Client </a>
          </li>
          <!-- <li>
            <a href="#"> Student </a>
          </li> -->
        </ul>   

        {{-- <li  data-toggle="collapse" data-target="#students" class="collapsed side-nav-li" ng-class="{ 'active' : admincon.active_student}">
            <a class="nav-link" href="{!! route('admin.manage.subject.index') !!}">
              Manage Subjects
            </a>
        </li> --}}           
    </ul>
</div>
