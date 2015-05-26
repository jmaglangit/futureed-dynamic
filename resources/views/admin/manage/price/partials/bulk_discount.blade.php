<div class="col-xs-12" ng-if="!sale.bulk_edit">
	<div class="row">
		<div class="col-xs-4 add-bulk">
			<button class="btn btn-success" data-toggle="collapse" data-target="#add-bulk-form" aria-expanded="false" aria-controls="add-bulk-form"><span><i class="fa fa-plus-square"></i></span> Add Bulk</button>
		</div>
	</div>
	<div class="row">
		<div class="collapse" id="add-bulk-form">
			<div class="add-bulk">
				{!! Form::open([
					'id' => 'bulk-form'
					, 'class' => 'form-horizontal'
					]) 
				!!}
				<div class="form-group">
					<label class="col-xs-2 control-label">Bulk Number <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('min_seats', '',
							[
								'class' => 'form-control',
								'ng-model' => 'sale.min_seats',
								'placeholder' => 'Bulk Number'
							]) 
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Discount <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('percentage', '',
							[
								'class' => 'form-control',
								'ng-model' => 'sale.percentage',
								'placeholder' => 'Discount'
							]) 
						!!}
					</div>
				</div>
				<div class="form-group">
	                <label class="col-xs-2 control-label" id="status">Status <span class="required">*</span></label>
	                <div class="col-xs-5">
	                	<div class="col-xs-6 checkbox">	                				
	                		<label>
	                		{!! Form::radio('b_status','Enabled', true) 
	                				!!}
	                		<span class="lbl padding-8">Enabled</span>
	                		</label>
	                	</div>
	                	<div class="col-xs-6 checkbox">
	                		<label>
	                		{!! Form::radio('b_status', 'Disabled', false) 
	                		!!}
	                		<span class="lbl padding-8">Disabled</span>
	                		</label>
	                	</div>
	                </div>
	            </div>
	            <div class="col-xs-7">
	                <div class="btn-container">
	                	<button class="btn btn-blue btn-medium" type="button" ng-click="sale.addBulk()">Add</button>
	                </div>
	            </div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 price-list" ng-init="sale.getBulkList()">
					<div class="list-container" ng-cloak>
						<table id="client-list" datatable="ng"class="table table-striped table-hover dt-responsive" style="width:100%">
							<thead>
				        <tr>
				            <th>Bulk Number</th>
				            <th>Discount</th>
				            <th width="200px;">Action</th>
				        </tr>
				        </thead>
				        <tbody>
				        <tr ng-repeat="b in sale.bulk">
				            <td>{! b.min_seats !}</td>
				            <td>{! b.percentage !}</td>
				            <td width="200px;">
				            	<div class="col-xs-12">
				            		<div class="row price-action">
					            		<div class="col-action">
					            			<a href="#" ng-click="sale.getBulk(b.id)">Edit</a>
					            		</div>
					            		<span class="separator">|</span>
					            		<div class="col-action">
					            			<a href="#" ng-click="sale.deleteBulk(b.id)">Delete</a>
					            		</div>
				            	</div>
				            	</div>
				            </td>
				        </tr>
				        </tbody>

						</table>
					</div>
				</div>
</div>