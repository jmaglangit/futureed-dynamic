@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
    <div class="row" ng-cloak>
        <div class="col-xs-12 class-container">
            <h3 class="alert alert-info">{!! trans('messages.student_dashboard_msg') !!}</h3>
            
            <div class="no-record-label">    
                <p>{!! trans('messages.student_dashboard_msg2') !!}</p>
                <p>{!! trans('messages.or') !!}</p>
                <p>{!! trans('messages.student_dashboard_msg3') !!}</p>
                <p ng-if="user.age > 13">{!! trans('messages.or') !!}</p>
                <p ng-if="user.age > 13">{!! trans('messages.student_dashboard_msg4') !!} <a href="{!! route('student.payment.index') !!}">{!! trans('messages.student_dashboard_msg5') !!}</a> {!! trans('messages.student_dashboard_msg6') !!}.</p>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop