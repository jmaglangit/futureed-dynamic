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

        <li  data-toggle="collapse" data-target="#students" class="collapsed side-nav-li" ng-class="{ 'active' : admincon.active_student}">
            <a class="nav-link" href="{!! route('admin.manage.subject.index') !!}">
              Manage Subjects
            </a>
        </li>           
    </ul>
</div>
