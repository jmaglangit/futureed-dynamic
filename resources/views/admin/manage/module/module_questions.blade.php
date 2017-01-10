@extends('admin.app')

@section('navbar')
    {{--@include('admin.partials.main-nav')--}}
@stop

@section('content')
    <div id="module" class="dshbrd-con" ng-controller="ManageModuleQuestionController as question"
         ng-init="question.setActive('',{!! $module !!})"
         ng-cloak>

        <div template-directive template-url="{!! route('admin.manage.module.partials.module_questions_preview') !!}"></div>

    </div>

@stop

@section('scripts')
    {!! Html::script('/js/admin/controllers/manage_module_question_controller.js')!!}
    {!! Html::script('/js/admin/services/manage_module_question_service.js')!!}

    {!! Html::script('/js/admin/controllers/manage_age_group_controller.js')!!}
    {!! Html::script('/js/admin/services/manage_age_group_service.js')!!}

    {!! Html::script('/js/admin/controllers/manage_module_content_controller.js')!!}
    {!! Html::script('/js/admin/services/manage_module_content_service.js')!!}

    {!! Html::script('/js/admin/controllers/manage_question_ans_controller.js')!!}
    {!! Html::script('/js/admin/services/manage_question_ans_service.js')!!}

    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js')!!}
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.resize.min.js')!!}
@stop