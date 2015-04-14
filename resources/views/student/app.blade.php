<!DOCTYPE html>
<html lang="en" ng-app="futureed">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FutureEd Online Education Platform</title>

    <!--[if IE]>
    <link rel="stylesheet" type="text/css" media="all" href="https://www.formstack.com/forms/css/3/ie.css?20140508" />
    <![endif]-->
    <!--[if IE 7]><link rel="stylesheet" type="text/css" media="all" href="https://www.formstack.com/forms/css/3/ie7.css" /><![endif]-->
    <!--[if IE 6]><link rel="stylesheet" type="text/css" media="all" href="https://www.formstack.com/forms/css/3/ie6fixes.css" /><![endif]-->


    <!-- Fonts -->
    {!! Html::style('http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css') !!}
    {!! Html::style('http://fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,500italic,700,700italic') !!}
    {!! Html::style('http://fonts.googleapis.com/css?family=Schoolbell') !!}
    
    <!-- CSS -->
    {!! Html::style('//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css') !!}
    {!! Html::style('/css/futureed.css') !!}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('styles')
  </head>
  <body class="student" ng-controller="futureedController" ng-cloak>
    <a id="top"></a>
    <header>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">FutureEd Logo Here</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
              <li><a href="#">Link</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                  <li class="divider"></li>
                  <li><a href="#">One more separated link</a></li>
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
              <li><a href="#">Link</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Welcome, new_user <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Profile</a></li>
                  <li><a href="#">Settings</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </header>

  	@yield('content')

    @section('footer')
      <footer class="footer">
        <div class="container text-center">
          <p class="text-muted">{{ date('Y') }} &copy; All Rights Reserved. FutureEd Pte Ltd</p>
        </div>
      </footer>
    @show

    <!-- START SCRIPTS -->
    {!! Html::script('/js/jquery.js') !!}
    {!! Html::script('//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js') !!}
    {!! Html::script('http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.13/angular.min.js') !!}
    {!! Html::script('http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.13/angular-resource.min.js') !!}
    {!! Html::script('http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.13/angular-route.min.js') !!}
    {!! Html::script('/js/futureed.js') !!}
    {!! Html::script('/js/futureed_controllers.js') !!}
    {!! Html::script('/js/futureed_services.js') !!}
    {!! Html::script('/js/jquery.smooth-scroll.js') !!}

    @yield('scripts')

    {!! Html::script('/js/student/app.js') !!}
    <!-- END SCRIPTS -->

  </body>
</html>