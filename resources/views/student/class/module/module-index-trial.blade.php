@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
    <div class="col-xs-12 module-contents-container" ng-controller="StudentTrialModuleController as mod"
         ng-init="mod.updateBackground();mod.retrieveTrialModule();" ng-cloak>

        <!-- Main Container -->
        <div class="col-xs-12 padding-0">
                <div template-directive template-url="{!! route('student.class.module.partials.trial.questions') !!}"></div>
        </div>
        <!-- End of Main Container -->

        <div template-directive template-url="{!! route('student.class.module.partials.view_question_message') !!}"></div>
    </div>
    <div class="clearfix"></div>
@stop

@section('scripts')
    {!! Html::script('/js/student/controllers/student_trial_module_controller.js')!!}
    {!! Html::script('/js/student/services/student_module_service.js')!!}

    {!! Html::script('/js/student/constants/student_module_constant.js')!!}
    {!! Html::script('/js/student/constants/student_help_constant.js')!!}

    {!! Html::script('/js/common/search_service.js')!!}
    {!! Html::script('/js/common/table_service.js')!!}
    {!! Html::script('//code.jquery.com/ui/1.9.2/jquery-ui.js')!!}
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js')!!}
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.resize.min.js')!!}
@stop

