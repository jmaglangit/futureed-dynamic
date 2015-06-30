<div ng-if="sale.active_client_discount_list">
      	<div class="row" ng-if = "!sale.active_client_discount_add && !sale.active_client_discount_edit">
		    <div class="col-xs-4 add-price">
		      	<button class="btn btn-blue" 
		      		ng-click="sale.setDiscountsActive('client_discount_add')">
		      		<span><i class="fa fa-plus-square"></i></span> Add Client Discount
		      	</button>
		    </div>
	  	</div>

	  	<div class="row" ng-if="sale.active_client_discount_add">
		    <div class="col-xs-12">
				<div class="title-mid">
					Add Client Discount
				</div>
			</div>
	  	</div>

	  	<div class="row" ng-if="sale.active_client_discount_edit">
		    <div class="col-xs-12">
				<div class="title-mid">
					Edit Client Discount
				</div>
			</div>
	  	</div>

      	<div class="row" ng-if="sale.active_client_discount_add || sale.active_client_discount_edit">
		      <div id="discount_form">
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
			      					'class' => 'form-control'
			      					, 'ng-model' => 'sale.data.name'
			      					, 'placeholder' => 'Name'
			      					, 'ng-disabled' => 'sale.active_client_discount_edit'
			      					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        						, 'ng-change' => 'sale.suggestClient()'
			      				])
			      			!!}
			      			<div class="angucomplete-holder" ng-if="sale.clients && sale.active_client_discount_add">
								<ul class="col-xs-5 angucomplete-dropdown">
									<li class="angucomplete-row" ng-repeat="client in sale.clients" ng-click="sale.selectClient(client)">
										{! client.first_name !} {! client.last_name !}
									</li>
								</ul>
							</div>


			      			{!! Form::hidden('client_id', null, 
			      				[
			      					'ng-model' => 'sale.data.client_id', 
			      				])
			      			!!}
		      			</div>
		      			<div class="margin-top-8" ng-if="sale.active_client_discount_add"> 
			                <i ng-if="sale.validation.c_loading" class="fa fa-spinner fa-spin"></i>
			                <span ng-if="sale.validation.c_error" class="error-msg-con">{! sale.validation.c_error !}</span>
			            </div>
		      		</div>
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Email</label>
		      			<div class="col-xs-5">
		      				{!! Form::text('email', '', 
			      				[	
			      					'class' => 'form-control' 
			      					, 'ng-disabled' => 'true'
			      					, 'ng-model' => 'sale.data.email'
			      					, 'placeholder' => 'Email Address'
			      				]) 
			      			!!}
		      			</div>
		      		</div>
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Percentage <span class="required">*</span></label>
		      			<div class="col-xs-5">
			      			<div class="input-group">
								{!! Form::text('percentage', '', 
				      				[	
				      					'class' => 'form-control' 
				      					, 'placeholder' => 'Discount Percentage'
				      					, 'ng-model' => 'sale.data.percentage'
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
	                				{!! Form::radio('example','Enabled', true, 
	                					[
	                						'class' => 'field', 
	                						'ng-model'=> 'sale.data.status'
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
	                						'ng-model'=> 'sale.data.status'
	                					]) 
	                				!!}
	                				<span class="lbl padding-8">Disabled</span>
	                				</label>
	                			</div>
	                		</div>
	                	</div>
	                	<div class="col-xs-7 col-xs-offset-1">
	                		<div class="btn-container">
	                			{!! Form::button('Edit'
	                				, array(
	                					'class' => 'btn btn-blue btn-medium'
	                					, 'ng-click' => "sale.updateClientDiscount()"
	                					, 'ng-if' => 'sale.active_client_discount_edit'
	                				)
	                			) !!}

	                			{!! Form::button('Add'
	                				, array(
	                					'class' => 'btn btn-blue btn-medium'
	                					, 'ng-click' => "sale.addClientDiscount()"
	                					, 'ng-if' => 'sale.active_client_discount_add'
	                				)
	                			) !!}

	                			{!! Form::button('Cancel'
	                				, array(
	                					'class' => 'btn btn-gold btn-medium'
	                					, 'ng-click' => "sale.setDiscountsActive('client_discount_list')"
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
					Client Discount List
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
						, 'ng-if' => "sale.discounts.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table id="discount-list" class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Name</th>
			            <th>Email</th>
			            <th>Role</th>
			            <th>Discount</th>
			            <th>Action</th>
			        </tr>
			        </thead>
			    <tbody>
			        <tr ng-repeat="p in sale.discounts">
			            <td>{! p.client.user.name !}</td>
			            <td>{! p.client.user.email !}</td>
			            <td>{! p.client.client_role !}</td>
			            <td>{! p.percentage | percent !}</td>
			            <td>
			            	<div class="row">
			            		<div class="col-xs-4">
			            			{! p.status !}
			            		</div>
			            		<div class="col-xs-4">
			            			<a href="" ng-click="sale.getDiscountDetails(p.id)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            		<div class="col-xs-4">
			            			<a href="" ng-click="sale.deleteClientDiscount(p.id)"><span><i class="fa fa-trash"></i></span></a>
			            		</div>
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="!sale.discounts.length">
			        	<td valign="top" colspan="5">
			        		No records found
			        	</td>
			        </tr>
			    </tbody>
			</table>
			<div class="pull-right" ng-if="sale.discounts.length">
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