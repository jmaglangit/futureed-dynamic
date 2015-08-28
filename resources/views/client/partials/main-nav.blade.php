
<header>
    <nav class="navbar navbar-default" ng-cloak>
        <div class="navcon">
        <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a href="{!! route('client.dashboard.index') !!}">{!! Html::image('/images/logo-sm.png') !!}</a>
            </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">
                    <!-- <li><a href="#">Link</a></li> -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Welcome, {! user.first_name !} <span class="caret"></span></a>
                        
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{!! route('client.profile.index') !!}">Profile</a></li>
                            <li><a href="{!! route('client.logout') !!}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
</header>
