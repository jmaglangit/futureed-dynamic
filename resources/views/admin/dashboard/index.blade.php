@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
		<div class="container dshbrd-con" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')				
			</div>
			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content">
						<span>Client Management</span>
					</div>
				</div>
				<div class="form-content col-xs-12">
	                <div class="col-xs-3" style="padding:0;">
						<div class="btn btn-gold">
							<div class="row">
								<i class="fa fa-plus-square"></i>
							</div>
							<div class="row">
								Add User
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="title-mid">
						Search
					</div>
				</div>
				<div class="col-xs-12 search-container">
					<div class="form-search">
						{!! Form::open(
							array('id' => 'search_form'
								, 'method' => 'POST'
								, 'class' => 'form-inline'
								)
							)!!}
						<div class="form-group">
							<div class="col-xs-5">
								{!! Form::text('search_name', ''
									,array(
										'placeholder' => 'Name'
										, 'ng-model' => 'search_name'
										, 'class' => 'form-control'
										)
								)!!}
							</div>
							<div class="col-xs-5">
								{!! Form::text('search_email', ''
									,array(
										'placeholder' => 'Email Address'
										, 'ng-model' => 'search_name'
										, 'class' => 'form-control'
										)
								)!!}
							</div>
							<div class="col-xs-2">
								{!! Form::button('Search'
									,array(
										'class' => 'btn btn-gold'
										)
								)!!}
							</div>
						</div>
						<div class="form-group" style="margin-top:20px;">
							<div class="col-xs-5">
								{!! Form::text('search_school', ''
									,array(
										'placeholder' => 'School'
										, 'ng-model' => 'search_name'
										, 'class' => 'form-control'
										)
								)!!}
							</div>
							<div class="col-xs-5">
								{!! Form::select('search_role', array('Teacher' => 'teacher', 'Principal' => 'principal')
									, null
									,array(
										'placeholder' => 'Email Address'
										, 'ng-model' => 'search_name'
										, 'class' => 'form-control'
										)
								)!!}
							</div>
							<div class="col-xs-2">
								{!! Form::button('clear'
									,array(
										'class' => 'btn btn-white'
										)
								)!!}
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="title-mid">
						Client List
					</div>
				</div>
				<div class="col-xs-12 table-container">
					<div class="list-container" ng-controller="DatatableController as datatable" ng-cloak>
						<table id="client-list" datatable="ng"class="table table-striped table-hover dt-responsive" style="width:100%">
							<thead>
				        <tr>
				            <th>Name</th>
				            <th>Email</th>
				            <th>Role</th>
				            <th>Action</th>
				        </tr>
				        </thead>
				        <tbody>
				        <tr ng-repeat="person in ::datatable.persons">
				            <td>{! person.id !}</td>
				            <td>{! person.firstName !}</td>
				            <td>{! person.lastName !}</td>
				            <td>
				            	<div class="row">
				            		<div class="col-xs-3">
				            			<span><i class="fa fa-eye"></i></span>
				            		</div>
				            		<div class="col-xs-3">
				            			<span><i class="fa fa-pencil"></i></span>
				            		</div>
				            		<div class="col-xs-3">
				            			<span><i class="fa fa-ban"></i></span>
				            		</div>
				            		<div class="col-xs-3">
				            			<span><i class="fa fa-trash	"></i></span>
				            		</div>	
				            	</div>
				            </td>
				        </tr>
				        </tbody>

						</table>
					</div>
				</div>
			</div>
		</div>		
	</div>
@stop

@section('footer')

@overwrite
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/datatables_controller.js')!!}
@stop