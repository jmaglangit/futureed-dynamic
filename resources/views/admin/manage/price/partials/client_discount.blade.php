    	<div class="col-xs-12">
    	<div class="row">
		    <div class="col-xs-4 add-price">
		      	<button class="btn btn-success" data-toggle="collapse" data-target="#add-discount-form" aria-expanded="false" aria-controls="add-form"><span><i class="fa fa-plus-square"></i></span> Add Client Discount</button>
		    </div>
      	</div>
      	<div class="row">
		      <div class="collapse" id="add-discount-form">
		      	<div class="price-form">
		      		{!! Form::open([
		      			'id' => 'price_form', 
		      			'class'=> 'form-horizontal'
		      			]) 
		      		!!}
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Name</label>
		      			<div class="col-xs-5">
		      				{!! Form::text('name', '', 
			      				[
			      					'class' => 'form-control', 
			      					'ng-model' => 'price.name', 
			      					'placeholder' => 'Name'
			      				])
			      			!!}
		      			</div>
		      		</div>
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Description</label>
		      			<div class="col-xs-5">
		      				{!! Form::textarea('description', '', 
			      				[
			      					'class' => 'form-control', 
			      					'rows' => '4', 
			      					'style' => 'resize:vertical;', 
			      					'ng-model' => 'price.description'
			      				]) 
			      			!!}
		      			</div>
		      		</div>
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Price</label>
		      			<div class="col-xs-5">
		      				{!! Form::text('price','',
		      					[
		      						'class' => 'form-control',
		      						'ng-model' => 'price.add_price'
		      					]) 
		      				!!}
		      			</div>
		      		</div>
		      		<div class="form-group">
	                		<label class="col-xs-2 control-label" id="status">Status</label>
	                		<div class="col-xs-5">
	                			<div class="col-xs-6 checkbox">	                				
	                				<label>
	                				{!! Form::radio('example','Enabled', true, 
	                					[
	                						'class' => 'field', 
	                						'ng-model'=> 'price.status'
	                					]) 
	                				!!}
	                				<span class="lbl padding-8">Enabled</span>
	                				</label>
	                			</div>
	                			<div class="col-xs-6 checkbox">
	                				<label>
	                				{!! Form::radio('example', 'Disabled', false, 
	                					[
	                						'class' => 'field', 
	                						'ng-model'=> 'price.status'
	                					]) 
	                				!!}
	                				<span class="lbl padding-8">Disabled</span>
	                				</label>
	                			</div>
	                		</div>
	                	</div>
	                	<div class="col-xs-7">
	                		<div class="btn-container">
	                			<button class="btn btn-blue btn-medium" type="button" ng-click="price.addPrice()">Add</button>
	                		</div>
	                	</div>
		      	</div>
		      </div>
		</div>
		<div class="col-xs-12 price-list" ng-init="sale.getDiscountList()">
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
				        <tr ng-repeat="p in price.discount">
				            <td>{! p.name !}</td>
				            <td>{! p.description !}</td>
				            <td>{! p.price !}</td>
				            <td width="200px;">
				            	<div class="col-xs-12">
				            		<div class="row price-action">
					            		<div class="col-xs-5">
					            			<a href="#" id="{! p.id !}">Disable</a>
					            		</div>
				            			<div class="col-xs-2">|</div>
					            		<div class="col-xs-5">
					            			<a href="#" ng-click="deletePrice()">Delete</a>
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