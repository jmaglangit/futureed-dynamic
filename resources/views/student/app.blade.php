<!DOCTYPE html>
<html lang="en" ng-app="futureed">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="learning platform, learning, education, online education, adaptive online learning, adaptive education"/>
    <meta name="description" content="Futurelesson is an adaptive online learning platform designed to help students learn at their own pace, and to optimize their learning path."/>
    <meta name="site" content="Public" />
    <meta name="rating" content="General" />
    <meta name="revisit-after" content="4 weeks" />
    <meta name="robots" content="all" />

    <title>FutureEd Online Education Platform</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <!--[if IE]>
    <link rel="stylesheet" type="text/css" media="all" href="https://www.formstack.com/forms/css/3/ie.css?20140508" />
    <![endif]-->
    <!--[if IE 7]><link rel="stylesheet" type="text/css" media="all" href="https://www.formstack.com/forms/css/3/ie7.css" /><![endif]-->
    <!--[if IE 6]><link rel="stylesheet" type="text/css" media="all" href="https://www.formstack.com/forms/css/3/ie6fixes.css" /><![endif]-->


    <!-- Fonts -->
    {!! Html::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css') !!}
    {!! Html::style('//fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,500italic,700,700italic') !!}
    {!! Html::style('//fonts.googleapis.com/css?family=Schoolbell') !!}
    {!! Html::style('/css/websleek/stylesheet.css') !!}
    {!! Html::style('/css/websleek/websleek.css') !!}
    
    <!-- CSS -->
    {!! Html::style('//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css') !!}
    {!! Html::style('/css/datetimepicker.css') !!}
    {!! Html::style('/css/futureed.css') !!}
    {!! Html::style('/css/futureed-student.css') !!}
    {!! Html::style('/css/chart/student-progress.css') !!}
{{--    {!! Html::style('/css/operations/w3.css') !!}--}}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('styles')
  </head>
  <body class="student" ng-controller="futureedController" ng-init="getUserDetails();">
    {!! Form::hidden('userdata', Session::get('student')) !!}

    @yield('navbar')

  	@yield('content')

    @section('footer')

        @include('common.modal-session-time-expired', ['link' => route('student.login')])
        @include('common.modal-multiple-session', ['link' => route('student.login')])

        <footer class="footer" ng-cloak>
            <div class="container text-center">
                <p class="text-muted">{{ date('Y') }} &copy; {!! trans('messages.all_right_reserved') !!} FutureEd Pte Ltd</p>
            </div>
        </footer>

    @show

    <!-- START SCRIPTS -->
    {!! Html::script('/js/jquery.js') !!}
    {!! Html::script('//code.jquery.com/ui/1.9.2/jquery-ui.js')!!}
    {!! Html::script('/js/ui-block.js') !!}
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js') !!}
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/humanize-plus/1.5.0/humanize.js') !!}
    {!! Html::script('https://d3js.org/d3.v4.min.js') !!}

    {!! Html::script('/js/common/tooltip_converter.js') !!}
    {!! Html::script('//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js') !!}
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.13/angular.min.js') !!}
    {!! Html::script('/js/ng-sortable.min.js')!!}
    {!! Html::script('/js/jquery.date-dropdowns.js') !!}
    
    {!! Html::script('/js/futureed_constants.js') !!}
    {!! Html::script('/js/futureed_utils.js') !!}
	{!! Html::script('/js/common/angular/marked.js')!!}
	{!! Html::script('/js/common/angular/markdown-preview.js')!!}
	{!! Html::script('/js/futureed.js') !!}
    {!! Html::script('/js/futureed_controllers.js') !!}
    {!! Html::script('/js/futureed_services.js') !!}
    {!! Html::script('/js/datetimepicker.js') !!}
    {!! Html::script('/js/common/filters.js') !!}
    {!! Html::script('/js/common/tooltip_service.js') !!}
    {!! Html::script('/js/ui-bootstrap-tpls-0.13.0.min.js') !!}

    {!! Html::script('/js/ng-file-upload-shim.min.js')!!}
    {!! Html::script('/js/ng-file-upload.min.js')!!}

    {!! Html::script('/js/common/FileSaver.min.js') !!}

    @yield('scripts')
    <!-- END SCRIPTS -->

  </body>
</html>