<div ng-if="sale.active_price_settings_list">
	<div class="row" ng-if = "!sale.active_price_settings_add && !sale.active_price_settings_edit">
	    <div class="col-xs-4 add-price">
	      	<button class="btn btn-blue" 
	      		ng-click="sale.setDiscountsActive('price_settings_add')">
	      		<span><i class="fa fa-plus-square"></i></span> Add Price
	      	</button>
	    </div>
  	</div>

  	<div class="row" ng-if="sale.active_price_settings_add">
	    <div class="col-xs-12">
			<div class="title-mid">
				Add Price
			</div>
		</div>
  	</div>

  	<div class="row" ng-if="sale.active_price_settings_edit">
	    <div class="col-xs-12">
			<div class="title-mid">
				Edit Price
			</div>
		</div>
  	</div>

  	<div class="row" ng-if="sale.active_price_settings_add || sale.active_price_settings_edit">
	      <div id="add-form">
	      	<div class="price-form">
	      		{!! Form::open([
	      			'id' => 'price_form', 
	      			'class'=> 'form-horizontal'
	      			]) 
	      		!!}
	      		<div class="form-group">
	      			<label class="col-xs-3 control-label">Subscription Name <span class="required">*</span></label>
	      			<div class="col-xs-5">
	      				{!! Form::text('name', '', 
		      				[
		      					'class' => 'form-control', 
		      					'ng-model' => 'sale.data.name', 
		      					'placeholder' => 'Name'
		      				])
		      			!!}
	      			</div>
	      		</div>
	      		<div class="form-group">
	      			<label class="col-xs-3 control-label">Description <span class="required">*</span></label>
	      			<div class="col-xs-5">
	      				{!! Form::textarea('description', '', 
		      				[
		      					'class' => 'form-control',
		      					'placeholder' => 'Description', 
		      					'rows' => '4', 
		      					'style' => 'resize:vertical;', 
		      					'ng-model' => 'sale.data.description'
		      				]) 
		      			!!}
	      			</div>
	      		</div>
	      		<div class="form-group">
	      			<label class="col-xs-3 control-label">Price <span class="required">*</span></label>
	      			<div class="col-xs-5">
	      				{!! Form::text('price','',
	      					[
	      						'class' => 'form-control',
	      						'placeholder' => 'Price',
	      						'ng-model' => 'sale.data.price'
	      					]) 
	      				!!}
	      			</div>
	      		</div>
	      		<div class="form-group">
	      			<label class="col-xs-3 control-label">Days <span class="required">*</span></label>
	      			<div class="col-xs-5">
	      				{!! Form::text('days','',
	      					[
	      						'class' => 'form-control',
	      						'placeholder' => 'Days',
	      						'ng-model' => 'sale.data.days'
	      					]) 
	      				!!}
	      			</div>
	      		</div>
	      		<div class="form-group">
                		<label class="col-xs-3 control-label" id="status">Status <span class="required">*</span></label>
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
                	<div class="col-xs-7 col-xs-offset-2">
                		<div class="btn-container">
                			{!! Form::button('Edit'
                				, array(
                					'class' => 'btn btn-blue btn-medium'
                					, 'ng-click' => "sale.editPrice()"
                					, 'ng-if' => 'sale.active_price_settings_edit'
                				)
                			) !!}

                			{!! Form::button('Add'
                				, array(
                					'class' => 'btn btn-blue btn-medium'
                					, 'ng-click' => "sale.addPrice()"
                					, 'ng-if' => 'sale.active_price_settings_add'
                				)
                			) !!}

                			{!! Form::button('Cancel'
                				, array(
                					'class' => 'btn btn-gold btn-medium'
                					, 'ng-click' => "sale.setDiscountsActive('price_settings_list')"
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
				Price List
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
					, 'ng-if' => "sale.price.length"
					, 'class' => 'form-control paginate-size pull-right'
				)
			) !!}
		</div>

		<table id="price-list" class="table table-striped table-bordered">
			<thead>
	        <tr>
	            <th>Subscription Name</th>
	            <th>Description</th>
	            <th>Price</th>
	            <th>Action</th>
	        </tr>
	        </thead>
	        <tbody>
	        <tr ng-repeat="p in sale.price">
	            <td>{! p.name !}</td>
	            <td>{! p.description !}</td>
	            <td>{! p.price !}</td>
	            <td>
	            	<div class="row">
	            		<div class="col-xs-4">
	            			{! p.status !}
	            		</div>
	            		<div class="col-xs-4">
	            			<a href="" ng-click="sale.getPrice(p.id)"><span><i class="fa fa-pencil"></i></span></a>
	            		</div>
	            		<div class="col-xs-4">
	            			<a href="" ng-click="sale.deletePrice(p.id)"><span><i class="fa fa-trash"></i></span></a>
	            		</div>
	            	</div>
	            </td>
	        </tr>
	        <tr class="odd" ng-if="!sale.price.length">
	        	<td valign="top" colspan="4" class="dataTables_empty">
	        		No records found
	        	</td>
	        </tr>
	        </tbody>
		</table>

		<div class="pull-right" ng-if="sale.price.length">
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