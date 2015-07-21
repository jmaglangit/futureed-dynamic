<div ng-if="sale.active_bulk_settings_list">
	<div class="row" ng-if = "!sale.active_bulk_settings_add && !sale.active_bulk_settings_edit">
	    <div class="col-xs-4 add-price">
	      	<button class="btn btn-blue" 
	      		ng-click="sale.setDiscountsActive('bulk_settings_add')">
	      		<span><i class="fa fa-plus-square"></i></span> Add Bulk Discount
	      	</button>
	    </div>
  	</div>

  	<div class="row" ng-if="sale.active_bulk_settings_add">
	    <div class="col-xs-12">
			<div class="title-mid">
				Add Bulk Discount
			</div>
		</div>
  	</div>

  	<div class="row" ng-if="sale.active_bulk_settings_edit">
	    <div class="col-xs-12">
			<div class="title-mid">
				Edit Bulk Discount
			</div>
		</div>
  	</div>

	<div class="row" ng-if="sale.active_bulk_settings_add || sale.active_bulk_settings_edit">
		<div id="add-bulk-form">
			<div class="add-bulk">
				{!! Form::open([
					'id' => 'bulk-form'
					, 'class' => 'form-horizontal'
					]) 
				!!}
				<div class="form-group">
					<label class="col-xs-2 control-label">Minimum Seats <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('min_seats', '',
							[
								'class' => 'form-control',
								'ng-model' => 'sale.data.min_seats',
								'placeholder' => 'Minimum Seats'
							]) 
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Discount <span class="required">*</span></label>
					<div class="col-xs-5">
						<div class="input-group">
							{!! Form::text('percentage', '',
								[
									'class' => 'form-control',
									'ng-model' => 'sale.data.percentage',
									'placeholder' => 'Discount'
								]) 
							!!}
		      				<span class="input-group-addon" id="basic-addon1">%</span>
						</div>
					</div>
				</div>
				<div class="form-group">
	                <label class="col-xs-2 control-label" id="status">Status <span class="required">*</span></label>
	                <div class="col-xs-5">
	                	<div class="col-xs-6 checkbox">	                				
	                		<label>
	                		{!! Form::radio('status'
            					, 'Enabled'
            					, true
            					, array(
        							'class' => 'field'
        							, 'ng-model' => 'sale.data.status'
    							) 
    						) !!}
	                		<span class="lbl padding-8">Enabled</span>
	                		</label>
	                	</div>
	                	<div class="col-xs-6 checkbox">
	                		<label>
	                		{!! Form::radio('status'
            					, 'Disabled'
            					, false
            					, array(
        							'class' => 'field'
        							, 'ng-model' => 'sale.data.status'
    							) 
            				) !!}
	                		<span class="lbl padding-8">Disabled</span>
	                		</label>
	                	</div>
	                </div>
	            </div>

	            <div class="col-xs-7 col-xs-offset-1">
                		<div class="btn-container">
                			{!! Form::button('Save'
                				, array(
                					'class' => 'btn btn-blue btn-medium'
                					, 'ng-click' => "sale.editBulk()"
                					, 'ng-if' => 'sale.active_bulk_settings_edit'
                				)
                			) !!}

                			{!! Form::button('Add Bulk Discount'
                				, array(
                					'class' => 'btn btn-blue btn-medium'
                					, 'ng-click' => "sale.addBulk()"
                					, 'ng-if' => 'sale.active_bulk_settings_add'
                				)
                			) !!}

                			{!! Form::button('Cancel'
                				, array(
                					'class' => 'btn btn-gold btn-medium'
                					, 'ng-click' => "sale.setDiscountsActive('bulk_settings_list')"
                				)
                			) !!}
                		</div>
                	</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="title-mid">
				Bulk List
			</div>
		</div>
	</div>

	<div class="list-container" ng-cloak>
		<div class="size-container">
			{!! Form::select('size'
				, array(
					  '10' => '10'
					, '20' => '20'
					, '50' => '50'
					, '100' => '100'
				)
				, '10'
				, array(
					'ng-model' => 'sale.table.size'
					, 'ng-change' => 'sale.paginateBySize()'
					, 'ng-if' => "sale.bulk.length"
					, 'class' => 'form-control paginate-size pull-right'
				)
			) !!}
		</div>

		<table id="bulk-list" class="table table-striped table-bordered">
			<thead>
		        <tr>
		            <th>Minimum Seats</th>
		            <th>Discount</th>
		            <th>Action</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="b in sale.bulk">
		            <td>{! b.min_seats !}</td>
		            <td>{! b.percentage | percent !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-4">
		            			{! b.status !}
		            		</div>
		            		<div class="col-xs-4">
		            			<a href="" ng-click="sale.getBulk(b.id)"><span><i class="fa fa-pencil"></i></span></a>
		            		</div>
		            		<div class="col-xs-4">
		            			<a href="" ng-click="sale.deleteBulk(b.id)"><span><i class="fa fa-trash"></i></span></a>
		            		</div>
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!sale.bulk.length">
			        	<td valign="top" colspan="4" class="dataTables_empty">
			        		No records found
			        	</td>
			        </tr>
		    </tbody>
		</table>
		<div class="pull-right" ng-if="sale.bulk.length">
			<pagination 
				total-items="sale.table.total_items" 
				ng-model="sale.table.page"
				max-size="3"
				items-per-page="sale.table.size" 
				previous-text = "&lt;"
				next-text="&gt;"
				class="pagination" 
				boundary-links="true"
				ng-change="sale.paginateByPage()">
			</pagination>
		</div>
	</div>
</div>