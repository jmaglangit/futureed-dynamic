<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>Future Lesson</title>

    <!-- Bootstrap core CSS -->
    {!! Html::style('//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'); !!}
            <!-- Fonts -->
    {!! Html::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'); !!}
    {!! Html::style('//fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,500italic,700,700italic'); !!}

            <!-- Custom styles for this template -->
    {!! Html::style('/css/datetimepicker.css') !!}
    {{--{!! Html::style('/css/futureed.css'); !!}--}}

    {!! Html::style('/css/futureed-client.css') !!}
    {!! Html::style('/css/angucomplete.css') !!}
    {!! Html::style('/css/datatables.bootstrap.min.css') !!}

</head>
<body>

<div class="container">
    @yield('content')
</div>
</body>
</html>