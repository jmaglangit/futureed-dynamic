
  <header>
      <nav class="navbar navbar-default" ng-cloak>
        <div class="navcon">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="#">{!! Html::image('/images/logo-sm.png') !!}</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="dropdown" ng-if="user.role == futureed.TEACHER">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Teacher <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="">
                  <a href="{!! route('client.teacher.student.index') !!}">Student</a>
                </li>
                <li class="">
                  <a href="{!! route('client.teacher.class.index') !!}">Class</a>
                </li>
              </ul>
            </li>
            <li class="dropdown" ng-if="user.role == futureed.PRINCIPAL">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Principal <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="">
                  <a href="{!! route('client.principal.teacher.index') !!}">Teacher</a>
                </li>
                <li class="">
                  <a href="{!! route('client.principal.payment.index') !!}">Payment</a>
                </li>
                <li class="">
                  <a href="{!! route('client.principal.invoice.index') !!}">Invoice</a>
                </li>
              </ul>
            </li>
            <li class="dropdown" ng-if="user.role == futureed.PARENT">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Parent <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="">
                  <a href="{!! route('client.parent.student.index') !!}">Student</a>
                </li>
                <li class="">
                  <a href="{!! route('client.parent.payment.index') !!}">Payment</a>
                </li>
                <li class="">
                  <a href="{!! route('client.parent.invoice.index') !!}">Invoice</a>
                </li>
              </ul>
            </li>
          </ul>
            <!-- 
            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
             -->
            <ul class="nav navbar-nav navbar-right">
              <!-- <li><a href="#">Link</a></li> -->
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Welcome, {! user.first_name !} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="{!! route('client.profile.index') !!}">Profile</a></li>
                  <li><a href="#">Settings</a></li>
                  <li class="divider"></li>
                  <li><a href="{!! route('client.logout') !!}">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div>
      </nav>
    </header>
