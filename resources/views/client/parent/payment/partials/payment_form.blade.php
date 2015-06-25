<div ng-if="payment.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Payment Management</span>
		</div>
	</div>
	<div class="col-xs-12 form-container">
		<div class="alert-container">
			<div class="alert alert-error" ng-if="payment.errors">
	            <p ng-repeat="error in payment.errors track by $index" > 
	              	{! error !}
	            </p>
	        </div>

	        <div class="alert alert-success" ng-if="payment.success">
	        	<p>Successfully deleted Invoice</p>
	        </div>
		</div>
		<div class="title-mid mid-container">
			Search
		</div>
	</div>
	<div class="col-xs-12 search-container">
		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'teacher_search',
						'class' => 'form-horizontal'
					]
			) !!}
			<div class="form-group">
				<label class="col-xs-2 control-label">Order # <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_order', '',['class' => 'form-control', 'ng-model' => 'payment.search.order_no', 'placeholder' => 'Name']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Subscription Name <span class="required">*</span></label>
				<div class="col-xs-5">
					<select name="subscription" ng-model="payment.search.subscription_name" ng-disabled="!payment.subscriptions.length" ng-init="payment.getSubscriptionList()"
									id="subscription" 
									class="form-control">
		                        <option value="">-- Select Subscription --</option>
		                        <option ng-repeat="subscription in payment.subscriptions" value="{! subscription.name !}">{! subscription.name!}</option>
		                    </select>
				</div>
				<div class="btn-container col-xs-5">
					{!! Form::button('Search'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => 'payment.searchFnc()'
						)
					) !!}
					{!! Form::button('Clear'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => 'payment.clear()'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>
	<button class="btn btn-blue btn-small margin-0-30" ng-click="payment.setActive('add')">
		<i class="fa fa-plus-square"></i> Add 
	</button>
	<div class="col-xs-12 padding-0-30">
		<div class="title-mid">
			Payment List
		</div>
	</div>
	<div class="col-xs-12 table-container" ng-init="payment.list()">
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
						'ng-model' => 'payment.table.size'
						, 'ng-change' => 'payment.paginateBySize()'
						, 'ng-if' => "payment.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Order #</th>
			            <th>Subscription Name</th>
			            <th>Date Started</th>
			            <th>Date End</th>
			            <th>Total # of Seats</th>
			            <th>Status</th>
			            <th>Total Price</th>
			            <th>Actions</th>
			        </tr>
			    </thead>

		        <tbody>
		        <tr ng-repeat="key in payment.records">
		            <td>{! key.order_no !}</td>
		            <td>{! key.subscription.name !}</td>
		            <td>{! key.date_start | ddMMyyyy !}</td>
		            <td>{! key.date_end | ddMMyyyy !}</td>
		            <td>{! key.seats_total !}</td>
		            <td>{! key.payment_status !}</td>
		            <td>{! key.total_amount !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-4">
	    						<a href="" ng-click="payment.setActive('view', key.id)" title="view"><span><i class="fa fa-eye"></i></span></a>
	    					</div>
	    					<div class="col-xs-4">
	    						<a href="" ng-click="payment.setActive('view', key.id)" title="cancel"><span><i class="fa fa-ban"></i></span></a>
	    					</div>
	    					<div class="col-xs-4">
	    						<a href="" ng-click="payment.deleteInvoice(key.id)" title="delete"><span><i class="fa fa-trash"></i></span></a>
	    					</div>
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!payment.records.length && !payment.table.loading">
		        	<td valign="top" colspan="7" class="dataTables_empty">
		        		No records found
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="payment.table.loading">
		        	<td valign="top" colspan="7" class="dataTables_empty">
		        		Loading...
		        	</td>
		        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="payment.records.length">
				<pagination 
					total-items="payment.table.total_items" 
					ng-model="payment.table.page"
					max-size="payment.table.paging_size"
					items-per-page="payment.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="payment.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>