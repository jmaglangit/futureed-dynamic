@extends('client.app')

@section('navbar')
    @include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con">
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')	
			</div>
			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content">
						<span>Client Dashboard</span>
					</div>
				</div>

				<div class="form-content col-xs-12">	
					<div class="dashboard-content" ng-cloak>
						{{--Principal--}}
						<div ng-if="user.role == futureed.PRINCIPAL">
							<p>To get started on using Future Lesson, you need to invite a
								<a href="{!! route('client.principal.teacher.index') !!}"> teacher</a> first to manage your classes.</p>
							<p>If you have already invited a Teacher, you need to go to the 
								<a href="{!! route('client.principal.payment.index') !!}"> payment</a> to buy seats for your classes.</p>
						</div>


						<div ng-if="user.role == futureed.PARENT">
							<p>
								To get started on using Future Lesson, you need to add a student, click
								<a href="{!! route('client.parent.student.index') !!}"> student</a>.
							</p>
							<p>If you already added a Student, you can
								<a href="{!! route('client.parent.payment.index') !!}"> buy a subject</a> for the your student</p>
							<p>You can also 
								<a href="{!! route('client.parent.module.index') !!}"> review</a> the lessons and practice questions.</p>
						</div>

						<div ng-if="user.role == futureed.TEACHER">
							<p>To get started on using Future Lesson, you need to add a student under a 
								<a href="{!! route('client.teacher.class.index') !!}"> class</a>.</p>
							<p>To see all your students, click
								<a href="{!! route('client.teacher.student.index') !!}"> student</a>.</p>
							<p>To review the lessons and practice questions, click on 
								<a href="{!! route('client.teacher.module.index') !!}"> module</a>.</p>
						</div>
					</div>
					<div class="client-principal-reports" ng-if="user.role == futureed.PRINCIPAL">
						<div class="report-options">>
							<ul>
								<li>
									<button class="btn btn-blue"><i class="fa fa-save"></i> Save</button>
								</li>
								<li>
									<button class="btn btn-blue"><i class="fa fa-file-pdf-o"></i> Export</button>
								</li>
								<li>
									<button class="btn btn-blue"><i class="fa fa-print"></i> Print</button>
								</li>
								<li>
									<button class="btn btn-blue"><i class="fa fa-envelope-o"></i> Email</button>
								</li>
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>  
@stop

@section('scripts')

@stop