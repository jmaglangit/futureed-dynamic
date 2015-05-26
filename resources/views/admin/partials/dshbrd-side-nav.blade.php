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
        <li  data-toggle="collapse" data-target="#students" class="collapsed side-nav-li" ng-class="{ 'active' : admincon.active_student}">
            <a class="nav-link">
              User Management <i class="fa fa-caret-down"></i>
            </a>
        </li>
        <ul class="sub-menu collapse" id="students">
            <li>
				        <a href=""><span><i class="fa fa-user"></i></span>Manage Admin</a>
            </li>

            <li>
                <a href="{!! route('admin.manage.client.index') !!}" ng-init="client.setManageClientActive()"><span><i class="fa fa-user"></i></span>Manage Client</a>
            </li>

            <li>
                <a href=""><span><i class="fa fa-user"></i></span>Manage Student</a>
            </li>
        </ul>

        <li data-toggle="collapse" data-target="#module" class="collapsed side-nav-li">
            <a class="dropdown-toggle nav-link">Module Management <i class="fa fa-caret-down"></i></a>
        </li>
        <ul class="sub-menu collapse" id="module">
            <li>
                <a href="{!! route('admin.manage.subject.index') !!}" ng-init="subject.setManageSubjectActive()"><span><i class="fa fa-book"></i>Subject</span></a>
            </li>

            <li>
                <a href="{!! route('admin.manage.grades.index') !!}" ng-init="grade.setManageGradeActive()"><span><i class="fa fa-book"></i>Grades</span></a>
            </li>
        </ul> 

        <li data-toggle="collapse" data-target="#price" class="collapsed side-nav-li" ng-class="{'active' : admincon.active_price}">
            <a class="dropdown-toggle nav-link">Price Management <i class="fa fa-caret-down"></i></a>
        </li>  
        <ul class="sub-menu collapse" id="price">
            <li>
                <a href="{!! route('admin.manage.price.index') !!}"><span><i class="fa fa-dollar"></i>Price & Discounts</span></a>
            </li>
        </ul>

        <li data-toggle="collapse" data-target="#master" class="collapsed side-nav-li" ng-class="{'active' : admincon.active_announcement}">
            <a class="dropdown-toggle nav-link">Master Settings <i class="fa fa-caret-down"></i></a>
        </li>  
        <ul class="sub-menu collapse" id="master">
<<<<<<< HEAD
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
=======
            <li>
                <a href="{!! route('admin.manage.announce.index') !!}"><span><i class="fa fa-bullhorn"></i>Announcement</span></a>
            </li>
        </ul>             
>>>>>>> f9003a6901bd37797017cde61231ba65460efb0d
    </ul>
</div>
