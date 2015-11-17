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
					<!-- <div class="dashboard-content" ng-cloak>
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
					</div> -->

					<div ng-if="user.role == futureed.TEACHER">
							<div class="report-options">
								<ul class="pull-right">
									<li>
										<button class="btn btn-blue"><i class="fa fa-save"></i> Save </button>
									</li>
									<li>
										<button class="btn btn-blue"><i class="fa fa-file-pdf-o"></i> Export </button>
									</li>
									<li>
										<button class="btn btn-blue"><i class="fa fa-print"></i> Print </button>
									</li>
									<li>
										<button class="btn btn-blue"><i class="fa fa-envelope-o"></i> Email </button>
									</li>
								</ul>
							</div>

							<div class="report-container">
								<ul class="nav nav-tabs report-nav" role="tablist">
									<li class="col-xs-6 active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-list-ul"></i> View class list</a></li>
									<li class="col-xs-6 class-list">
										<select class="form-control">
											<option> Test </option>
										</select>
									</li>
								</ul>

								<!-- teacher details -->
								<div>
									<h3><i class="fa fa-th-list"></i> Teacher Details</h3>
									<table class="table table-bordered">
										<tr>
											<td class="col-xs-3">Class Name</td>
											<td>Lorem ipsum blah blah...</td>
										</tr>
										<tr>
											<td class="col-xs-3">Class Level</td>
											<td>Lorem ipsum blah blah...</td>
										</tr>
									</table>
								</div>

								<!-- student status -->
								<div>
									<h3><i class="fa fa-file-text"></i> Student Status</h3>
									<table class="table table-bordered">
										<tr class="magenta">
											<td class="col-xs-4">Student Name</td>
											<td class="col-xs-4">Status</td>
											<td class="col-xs-4">Other Details</td>
										</tr>
										<tr>
											<td>test</td>
											<td>test</td>
											<td>test</td>
										</tr>
										<tr>
											<td>test</td>
											<td>test</td>
											<td>test</td>
										</tr>
										<tr>
											<td>test</td>
											<td>test</td>
											<td>test</td>
										</tr>
									</table>	
								</div>

								<!-- students to watch-->
								<div>
									<h3><i class="fa fa-user"></i> Students to watch</h3>
									<table class="table table-bordered">
										<tr>
											<td class="col-xs-3">Excelling</td>
											<td>Lorem ipsum blah blah...</td>
										</tr>
										<tr>
											<td class="col-xs-3">Struggling</td>
											<td>Lorem ipsum blah blah...</td>
										</tr>
									</table>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>  
@stop

@section('scripts')

@stop