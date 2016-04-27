<header>
    <nav class="navbar navbar-default" ng-cloak>
        <div class="navcon">
            <div class="navbar-header">
                <a href="{!! route('client.dashboard.index') !!}">{!! Html::image('/images/logo-sm-beta.png') !!}</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Welcome, {! user.first_name !} <span class="caret"></span></a>
                        
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{!! route('client.profile.index') !!}">Profile</a></li>
                            <li>
                                <a  ng-if="!user.impersonate" href="javascript:void(0)" ng-click="logout(user.id, futureed.CLIENT, '{!! route('client.logout') !!}')">
                                <span>Logout</span>
                            </a>
                                <a ng-if="user.impersonate" href="javascript:void(0)" ng-click="stopImpersonate(user.user_id, '{!! route('client.logout') !!}')">
                                    <span >Stop Impersonating</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
