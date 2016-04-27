@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
    <div class="container class-con" ng-controller="StudentTrialClassController as class" ng-cloak>
        <div ng-if="student_details_updated == futureed.TRUE">
            <div ng-init="class.updateBackground()"></div>
            <div template-directive template-url="{!! route('student.class.partials.trial.module') !!}"></div>
        </div>
    </div>
@stop

@section('scripts')
    {!! Html::script('/js/student/controllers/student_trial_class_controller.js')!!}
    {!! Html::script('/js/student/services/student_class_service.js')!!}

    {!! Html::script('/js/common/search_service.js')!!}
    {!! Html::script('/js/common/table_service.js')!!}
    {!! Html::script('/js/student/class.js')!!}
@stop