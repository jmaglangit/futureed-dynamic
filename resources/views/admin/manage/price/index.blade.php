@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="AdminDashboardController as admincon" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')				
			</div>
			<div class="price-content">
				<div class="content-title">
					<div class="title-main-content">
						<span><i class="fa fa-gear"></i> Price & Discounts</span>
					</div>
				</div>
				<div class="form-content col-xs-12" ng-controller="PriceController as price">
					<div class="aler alert-danger" ng-if="price.errors">
						<p ng-repeat="error in price.errors">
							{! error !}
						</p>
					</div>
					<ul class="nav nav-tabs">
					    <li class="active"><a data-toggle="pill" href="#home"><span><i class="fa fa-dollar"></i>Price Settings</span></a></li>
					    <li><a data-toggle="pill" href="#discount"><span><i class="fa fa-tags"></i>Client Discount</span></a></li>
					    <li><a data-toggle="pill" href="#bulk"><span><i class="fa fa-database"></i>Bulk Settings</span></a></li>
					  </ul>
					  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
    	<div class="col-xs-12">
    	<div class="row">
		    <div class="col-xs-4 add-price">
		      	<button class="btn btn-success" data-toggle="collapse" data-target="#add-form" aria-expanded="false" aria-controls="add-form"><span><i class="fa fa-plus-square"></i></span> Add Price</button>
		    </div>
      	</div>
      	<div class="row">
		      <div class="collapse" id="add-form">
		      	<div class="price-form">
		      		{!! Form::open(['id' => 'price_form', 'class'=> 'form-horizontal']) !!}
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Name</label>
		      			<div class="col-xs-5">
		      				{!! Form::text('name', '', ['class' => 'form-control', 'ng-model' => 'price.name', 'placeholder' => 'Name'])!!}
		      			</div>
		      		</div>
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Description</label>
		      			<div class="col-xs-5">
		      				{!! Form::textarea('description', '', ['class' => 'form-control', 'rows' => '4', 'style' => 'resize:vertical;']) !!}
		      			</div>
		      		</div>
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Price</label>
		      			<div class="col-xs-5">
		      				{!! Form::text('price','',['class' => 'form-control','ng-model' => 'price.price']) !!}
		      			</div>
		      		</div>
		      		<div class="form-group">
	                		<label class="col-xs-2 control-label" id="status">Status</label>
	                		<div class="col-xs-5">
	                			<div class="col-xs-6 checkbox">	                				
	                				<label>{!! Form::radio('example', 1, false, ['class' => 'field']) !!}
	                				<span class="lbl padding-8">Enabled</span>
	                				</label>
	                			</div>
	                			<div class="col-xs-6 checkbox">
	                				<label>{!! Form::radio('example', 1, true, ['class' => 'field']) !!}
	                				<span class="lbl padding-8">Disabled</span>
	                				</label>
	                			</div>
	                		</div>
	                	</div>
	                	<div class="col-xs-7">
	                		<div class="btn-container">
	                			<button class="btn btn-blue btn-medium">Add</button>
	                		</div>
	                	</div>
		      	</div>
		      </div>
		</div>
		<div class="col-xs-12 price-list">
					<div class="list-container" ng-cloak>
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
				        <tr ng-repeat="person in ::persons" data-id>
				            <td>{! person.id !}</td>
				            <td>{! person.firstName !}</td>
				            <td>{! person.lastName !}</td>
				            <td>
				            	<div class="row">
				            		<div class="col-xs-3">
				            			<a href="#" id="{! person.id !}"><span><i class="fa fa-eye"></i></span></a>
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
    <div id="discount" class="tab-pane fade">
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="bulk" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
  </div>
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
	{!! Html::script('/js/admin/controllers/dashboard_controller.js')!!}
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js')!!}
	{!! Html::script('/js/admin/controllers/announcement_controller.js')!!}
	{!! Html::script('/js/admin/services/announcement_service.js')!!}

@stop