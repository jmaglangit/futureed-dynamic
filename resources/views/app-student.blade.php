<!DOCTYPE html>
<html lang="en" ng-app="futureed">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="">
  <title>FutureEd Online Education Platform</title>
  <!--[if IE]>
  <link rel="stylesheet" type="text/css" media="all" href="https://www.formstack.com/forms/css/3/ie.css?20140508" />
  <![endif]-->
  <!--[if IE 7]><link rel="stylesheet" type="text/css" media="all" href="https://www.formstack.com/forms/css/3/ie7.css" /><![endif]-->
  <!--[if IE 6]><link rel="stylesheet" type="text/css" media="all" href="https://www.formstack.com/forms/css/3/ie6fixes.css" /><![endif]-->

  <!-- Bootstrap core CSS -->
  <link href="/css/bootstrap.css" rel="stylesheet">
  <!-- Fonts -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
  <!-- Custom styles for this template -->
  <link href="/css/admin.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
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


	<footer class="footer">
	  <div class="container text-center">
	    <p class="text-muted">2015 &copy; All Rights Reserved. FutureEd Pte Ltd</p>
	  </div>
	</footer>

  <!-- START SCRIPTS -->
  <script src="/js/jquery.js"></script>
  <script src="/js/angular.js"></script>
  <script src="/js/futureed.js"></script>
  <script src="/js/bootstrap.js"></script>
  <script src="/js/jquery.smooth-scroll.js"></script>
  <script>
    $('a').smoothScroll();  
  </script>
  <script>
    $("#user_principal").click(function() {
      $("#principal, #form_schoolname, #form_address, #form_address2, #form_postcode").show( "slow");
      $("#parent").hide("slow");
      $("#user_teacher, #user_parent").fadeTo("slow", 0.3);
      $(this).fadeTo("slow", 1);
    });
    $("#user_teacher").click(function() {
      $("#form_address, #form_address2, #form_postcode" ).hide( "slow");
      $("#parent").hide("slow");
      $("#principal, form_schoolname").show("slow");
      $("#user_principal, #user_parent").fadeTo("slow", 0.3);
      $(this).fadeTo("slow", 1);
    });
    $("#user_parent").click(function() {
      $("#principal").hide("slow");
      $("#parent").show("slow");
      $("#user_principal, #user_teacher").fadeTo("slow", 0.3);
      $(this).fadeTo("slow", 1);
    });
  </script>
  <!-- END SCRIPTS -->
</body></html>
