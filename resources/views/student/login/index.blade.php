@extends('student.app')

@section('content')
    <div class="container login student-fnt" ng-controller="StudentLoginController as login" 
        ng-init="login.initMediaIds('{!! env('FB_APP_ID') !!}', '{!! env('GL_CLIENT_ID') !!}')" ng-cloak>
            
        {!! Form::open(array('id' => 'process_form', 'method' => 'POST', 'route' => 'student.login.process')) !!}
            {!! Form::hidden('user_data', '') !!}
        {!! Form::close() !!}

        <div ng-init="login.checkStudent('{!! $id !!}');">

            <div template-directive template-url="{!! route('student.login.confirm_media') !!}"></div>

            <div template-directive template-url="{!! route('student.login.enter_password') !!}"></div>

            <div template-directive template-url="{!! route('student.login.index_form') !!}"></div>
        </div>
    </div>

    <div class="col-xs-12" style="padding-top: 10px;padding-bottom: 10px; color: whitesmoke;">
        {!! Html::link(url('/lang/en'), 'English - US'
              , array(
                  'class' => 'col-xs-offset-5 col-xs-1',
                  'style' => 'text-decoration:none;color: whitesmoke;',

              )
          ) !!}
        {!! Html::link(url('/lang/id'), 'Bahasa Indonesia'
                , array(
                    'class' => 'col-xs-6',
                    'style' => 'text-decoration:none;color: whitesmoke;',

                )
            ) !!}
        {{--<p class="col-xs-offset-5 col-xs-1"></p>--}}
        {{--<p class="col-xs-6">Bahasa Indonesia</p>--}}
    </div>
@stop

@section('scripts')
    {!! Html::script('//connect.facebook.net/en_US/sdk.js') !!}
    {!! Html::script('https://apis.google.com/js/platform.js') !!}
    {!! Html::script('https://apis.google.com/js/client.js') !!}

    {!! Html::script('/js/common/validation_service.js') !!}

    {!! Html::script('/js/student/controllers/media_login_controller.js') !!}
    {!! Html::script('/js/student/services/media_login_service.js') !!}

	{!! Html::script('/js/student/controllers/login_controller.js') !!}
    {!! Html::script('/js/student/services/login_service.js') !!}

    {!! Html::script('/js/student/login.js') !!} 
@stop
