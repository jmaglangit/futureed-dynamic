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
        <center class="col-xs-offset-4 col-xs-4">
            <span style="margin-right: 3px;font-size: 13px;color: #D2476E;">Languages: </span>
        {!! Html::link(url('/lang/en'), 'English - US, '
              , array(
                  'style' => 'text-decoration:none;color: #F2D84F;font-size: 13px;margin-right: 7px',
              )
          ) !!}

        {!! Html::link(url('/lang/id'), 'Bahasa Indonesia, '
                , array(
                    'style' => 'text-decoration:none;color: #F2D84F;font-size: 13px;margin-right: 7px',
                )
            ) !!}

        {!! Html::link(url('/lang/th'), 'Thai, '
                , array(
                    'style' => 'text-decoration:none;color: #F2D84F;font-size: 13px;margin-right: 7px',
                )
            ) !!}
        </center>
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
