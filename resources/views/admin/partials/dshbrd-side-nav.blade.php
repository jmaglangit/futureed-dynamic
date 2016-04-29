<div class="client-prof">
	<div class="client-title">
		{{ trans('messages.admin_dashboard') }}
	</div>
	<div class="client-name">
		{{ trans('messages.welcome') }}, {! user.first_name !}
	</div>
</div>

<div class="nav-menu">
    <ul id="menu-content" class="nav-list">
        <li data-toggle="collapse" data-target="#students" data-parent="#menu-content" class="collapsed side-nav-li" ng-class="{ 'active' : admincon.active_student}" ng-if="user.admin_role == futureed.SUPER_ADMIN">
            <a href="" class="nav-link">
              {{ trans('messages.admin_user_mgmt') }} <i class="fa fa-caret-down"></i>
            </a>
        </li>
        <ul class="sub-menu collapse" ng-class="{ 'in' : admin || client || student }" id="students" ng-if="user.admin_role == futureed.SUPER_ADMIN">
            <li>
				<a href="{!! route('admin.manage.admin.index') !!}" ng-init="admin.setActive()"><span><i class="fa fa-user"></i></span>{{ ucfirst(trans('messages.admin_manage_admin')) }}</a>
            </li>

            <li>
                <a href="{!! route('admin.manage.client.index') !!}" ng-init="client.setManageClientActive()"><span><i class="fa fa-user"></i></span>{{ ucfirst(trans('messages.admin_manage_client')) }}</a>
            </li>

            <li>
                <a href="{!! route('admin.manage.student.index') !!}"><span><i class="fa fa-user"></i></span>{{ ucfirst(trans('messages.admin_manage_student')) }}</a>
            </li>
        </ul>

        <li data-toggle="collapse" data-target="#module" data-parent="#menu-content" class="collapsed side-nav-li">
            <a href="" class="nav-link">{{ trans('messages.admin_module_management') }} <i class="fa fa-caret-down"></i></a>
        </li>
        <ul class="sub-menu collapse" ng-class="{ 'in' : subject || grade }" id="module">
            <li>
                <a href="{!! route('admin.manage.subject.index') !!}" ng-init="subject.setManageSubjectActive()"><span><i class="fa fa-book"></i>{{ trans('messages.subject') }}</span></a>
            </li>

            <li>
                <a href="{!! route('admin.manage.grades.index') !!}" ng-init="grade.setActive()"><span><i class="fa fa-book"></i>{{ trans_choice('messages.grade', 1) }}</span></a>
            </li>
            <li>
                <a href="{!! route('admin.manage.module.index') !!}" ng-init="module.setManageModuleActive()"><span><i class="fa fa-cubes"></i>{{ trans_choice('messages.module', 1) }}</span></a>
            </li>
        </ul> 

        <li data-toggle="collapse" data-target="#price" data-parent="#menu-content" class="collapsed side-nav-li" ng-class="{'active' : admincon.active_price}">
            <a href="" class="nav-link">{{ trans('messages.admin_price_mgmt') }} <i class="fa fa-caret-down"></i></a>
        </li>  
        <ul class="sub-menu collapse" ng-class="{ 'in' : sale || invoice }" id="price">
            <li>
                <a href="{!! route('admin.manage.price.index') !!}" ng-init="sale.setDiscountsActive()"><span><i class="fa fa-dollar"></i>{{ trans('messages.admin_price_discounts') }}</span></a>
            </li>
            <li>
                <a href="{!! route('admin.manage.invoice.index') !!}"><span><i class="fa fa-file-text-o"></i>{{ trans('messages.admin_invoice') }}</span></a>
            </li>
        </ul>

        <li data-toggle="collapse" data-target="#master" data-parent="#menu-content" class="collapsed side-nav-li" ng-class="{'active' : admincon.active_announcement}">
            <a href="" class="nav-link">{{ trans('messages.admin_master_settings') }} <i class="fa fa-caret-down"></i></a>
        </li>  
        <ul class="sub-menu collapse" ng-class="{ 'in' : tips || announce || logs }" id="master">
            <li ng-class="{ 'active' : announce }">
                <a href="{!! route('admin.manage.announce.index') !!}"><span><i class="fa fa-bullhorn"></i>{{ trans('messages.announcement') }}</span></a>
            </li>
            <li ng-class="{ 'active' : tips }">
                <a href="{!! route('admin.manage.tips.index') !!}"><span><i class="fa fa-lightbulb-o"></i> {{ trans('messages.tips_and_help_request') }}</span></a>
            </li>
            <li ng-class="{ 'active' : logs }">
                <a href="{!! route('admin.manage.logs.index') !!}"><span><i class="fa fa-file-o"></i> {{ trans('messages.logs') }} </span></a>
            </li>
        </ul>
    </ul>
</div>
