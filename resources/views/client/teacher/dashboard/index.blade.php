
@extends('client.app')

@section('navbar')
    @include('client.partials.main-nav')
@stop

@section('content')
    <div class="dashboard-content" ng-cloak>
        <div ng-if="user.role == futureed.TEACHER">
            <p>To get started on using Future Lesson, you need to add a student under a
                <a href="{!! route('client.teacher.class.index') !!}"> class</a>.</p>

            <p>To see all your students, click
                <a href="{!! route('client.teacher.student.index') !!}"> student</a>.</p>

            <p>To review the lessons and practice questions, click on
                <a href="{!! route('client.teacher.module.index') !!}"> module</a>.</p>
        </div>
    </div>
@stop


