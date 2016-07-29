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

    <div class="col-xs-12" style="padding-top: 10px;padding-bottom: 10px; color: whitesmoke; position: relative; bottom: 26px;">
        <center>
            <div class="dropup col-xs-offset-4 col-xs-4 border-radius-3" style="background-color: #A92147;padding:5px;">
                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="background-color: #A92147;">-- Choose Language --</button>
                <ul class="dropdown-menu" style="background-color: #A92147;">
                    <li>
                        {!! Html::link(url('/lang/ar'), 'Arabic '
                            , array(
                                'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                            )
                        ) !!}
                    </li>

                    <li>
                        {!! Html::link(url('/lang/id'), 'Bahasa Indonesia '
                                , array(
                                    'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                )
                            ) !!}
                    </li>

                    <li>
                        {!! Html::link(url('/lang/ms'), 'Bahasa Malaysia '
                                , array(
                                    'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                )
                            ) !!}
                    </li>

                    <li>
                        {!! Html::link(url('/lang/my'), 'Burmese '
                                , array(
                                    'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                )
                            ) !!}
                    </li>

                    <li>
                        {!! Html::link(url('/lang/es'), 'Español '
                                , array(
                                    'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                )
                            ) !!}
                    </li>

                    <li>
                        {!! Html::link(url('/lang/en'), 'English - US '
                              , array(
                                  'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                              )
                          ) !!}
                    </li>

                    <li>
                        {!! Html::link(url('/lang/pt'), 'Portuguese '
                                , array(
                                    'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                )
                            ) !!}
                    </li>

                    <li>
                        {!! Html::link(url('/lang/th'), 'Thai '
                                , array(
                                    'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                )
                            ) !!}
                    </li>

                    <li>
                        {!! Html::link(url('/lang/vi'), 'Vietnamese '
                                , array(
                                    'style' => 'text-decoration:none;color: whitesmoke;font-size: 13px;margin-right: 7px; background-color: #A92147;',
                                )
                            ) !!}
                    </li>
                </ul>
            </div>
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
