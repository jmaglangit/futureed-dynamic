    	<div class="col-xs-12" ng-if="!sale.edit_price">
    	<div class="row">
		    <div class="col-xs-4 add-price">
		      	<button class="btn btn-success" data-toggle="collapse" data-target="#add-form" aria-expanded="false" aria-controls="add-form"><span><i class="fa fa-plus-square"></i></span> Add Price</button>
		    </div>
      	</div>
      	<div class="row">
		      <div class="collapse" id="add-form">
		      	<div class="price-form">
		      		{!! Form::open([
		      			'id' => 'price_form', 
		      			'class'=> 'form-horizontal'
		      			]) 
		      		!!}
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Name <span class="required">*</span></label>
		      			<div class="col-xs-5">
		      				{!! Form::text('name', '', 
			      				[
			      					'class' => 'form-control', 
			      					'ng-model' => 'sale.name', 
			      					'placeholder' => 'Name'
			      				])
			      			!!}
		      			</div>
		      		</div>
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Description <span class="required">*</span></label>
		      			<div class="col-xs-5">
		      				{!! Form::textarea('description', '', 
			      				[
			      					'class' => 'form-control',
			      					'placeholder' => 'Description', 
			      					'rows' => '4', 
			      					'style' => 'resize:vertical;', 
			      					'ng-model' => 'sale.description'
			      				]) 
			      			!!}
		      			</div>
		      		</div>
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Price <span class="required">*</span></label>
		      			<div class="col-xs-5">
		      				{!! Form::text('price','',
		      					[
		      						'class' => 'form-control',
		      						'placeholder' => 'Price',
		      						'ng-model' => 'sale.add_price'
		      					]) 
		      				!!}
		      			</div>
		      		</div>
		      		<div class="form-group">
	                		<label class="col-xs-2 control-label" id="status">Status <span class="required">*</span></label>
	                		<div class="col-xs-5">
	                			<div class="col-xs-6 checkbox">	                				
	                				<label>
	                				{!! Form::radio('status','Enabled',true) 
	                				!!}
	                				<span class="lbl padding-8">Enabled</span>
	                				</label>
	                			</div>
	                			<div class="col-xs-6 checkbox">
	                				<label>
	                				{!! Form::radio('status', 'Disabled',false) 
	                				!!}
	                				<span class="lbl padding-8">Disabled</span>
	                				</label>
	                			</div>
	                		</div>
	                	</div>
	                	<div class="col-xs-7">
	                		<div class="btn-container">
	                			<button class="btn btn-blue btn-medium" type="button" ng-click="sale.addPrice()">Add</button>
	                		</div>
	                	</div>
		      	</div>
		      </div>
		</div>
		<div class="col-xs-12 price-list" ng-init="sale.getPriceList()">
					<div class="list-container" ng-cloak>
						<table id="client-list" datatable="ng"class="table table-striped table-hover dt-responsive" style="width:100%">
							<thead>
				        <tr>
				            <th>Name</th>
				            <th>Description</th>
				            <th>Price</th>
				            <th width="200px;">Action</th>
				        </tr>
				        </thead>
				        <tbody>
				        <tr ng-repeat="p in sale.price">
				            <td>{! p.name !}</td>
				            <td>{! p.description !}</td>
				            <td>{! p.price !}</td>
				            <td width="200px;">
				            	<div class="col-xs-12">
				            		<div class="row price-action">
					            		<div class="col-action">
					            			<a href="#" id="{! p.id !}">Disable</a>
					            		</div>
					            		<span class="separator">|</span>
					            		<div class="col-action">
					            			<a href="#" ng-click="sale.getPrice(p.id)">Edit</a>
					            		</div>
					            		<span class="separator">|</span>
					            		<div class="col-action">
					            			<a href="#" ng-click="sale.deletePrice(p.id)">Delete</a>
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