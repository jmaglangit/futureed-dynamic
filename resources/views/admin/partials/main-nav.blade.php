
  <header>
      <nav class="navbar navbar-default" ng-cloak>
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="#"><img ng-src="/images/logo-sm.png" /></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- 
            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
             -->
             <ul class="nav navbar-nav">
               <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Manage <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>{!! Html::link(route('admin.manage.admin.index'), 'Admin') !!}</li>
                <li>{!! Html::link(route('admin.manage.client.index'), 'Client') !!}</li>
              </ul>
            </li>
             </ul>
            <ul class="nav navbar-nav navbar-right">
              <!-- <li><a href="#">Link</a></li> -->
              <li>
                <p>Welcome, Seymour</p>
              </li>
              <li>
                <a href="{!! route('admin.logout') !!}">Logout</a>
              </li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div>
      </nav>
    </header>
