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
        <li id="client_nav_head" data-target="client" class="active side-nav-li">
			<a href="" class="nav-link">Client</a>
		</li>
		<ul class="sub-menu" id="client">
        	<li ng-class="{ 'active' : client.active_add_client }">
				<a href="" ng-click="client.setManageClientActive('add_client')"><span><i class="fa fa-plus-square"></i></span>Add Client</a>
			</li>
			<li ng-class="{ 'active' : client.active_client_list }">
				<a href="" ng-click="client.setManageClientActive()"><span><i class="fa fa-list-alt"></i></span>View Client List</a>
			</li>
        </ul>                 
    </ul>
</div>
