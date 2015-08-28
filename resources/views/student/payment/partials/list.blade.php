<div ng-if="payment.active_list">
	<div class="col-xs-12 success-container" ng-if="payment.errors || payment.success">
		<div class="alert alert-error" ng-if="payment.errors">
			<p ng-repeat="error in payment.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="payment.success">
            <p>{! payment.success !}</p>
        </div>
    </div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
		</div>

		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'payment.searchFnc($event)'
					]
			) !!}
			<div class="form-group">
				<div class="col-xs-4">
					{!! Form::text('order_no', ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'payment.search.order_no'
							, 'placeholder' => 'Order Number'
							, 'autocomplete' => 'off'
						)
					) !!}
				</div>
				<div class="col-xs-4">
					<select ng-model="payment.search.subscription_name" ng-disabled="!payment.subscriptions.length" ng-init="payment.listSubscription()" class="form-control">
						<option value="">-- Select Subscription --</option>
						<option ng-repeat="subscription in payment.subscriptions" ng-value="subscription.name">{! subscription.name !}</option>
					</select>
				</div>
				<div class="col-xs-2">
					{!! Form::button('Search'
						, array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'payment.searchFnc($event)'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('Clear'
						, array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'payment.clear()'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 table-container" ng-init="payment.listPayments()">
		<button class="btn btn-blue btn-small" ng-click="payment.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> Add Payment
		</button>

		<div class="title-mid">
			Payment List
		</div>

		<div class="list-container" ng-cloak>
			<table class="table table-striped table-bordered table-responsive">
				<thead>
			        <tr>
			            <th>Order #</th>
			            <th>Subscription Name</th>
			            <th>Date Started</th>
			            <th>Date End</th>
			            <th>Total # of Seats</th>
			            <th>Total Price</th>
			            <th>Payment Status</th>
			            <th>Action</th>
			        </tr>
			    </thead>

		        <tbody>
		        <tr ng-repeat="record in payment.records">
		            <td>{! record.order_no !}</td>
		            <td>{! record.subscription.name !}</td>
		            <td>{! record.date_start | ddMMyy !}</td>
		            <td>{! record.date_end | ddMMyy !}</td>
		            <td>{! record.seats_total !}</td>
		            <td>{! record.total_amount | currency : "USD$ " : 2 !}</td>
		            <td>{! record.payment_status !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-6" title="View">
	    						<a href="" ng-click="payment.setActive(futureed.ACTIVE_VIEW, record.id)"><span><i class="fa fa-eye"></i></span></a>
	    					</div>
	    					<div class="col-xs-6" title="Delete">
	    						<a href="" ng-if="record.payment_status == futureed.PENDING" ng-click="payment.confirmDelete(record.id)"><span><i class="fa fa-trash"></i></span></a>
	    					</div>
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!payment.records.length && !payment.table.loading">
		        	<td valign="top" colspan="8">
		        		No records found
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="payment.table.loading">
		        	<td valign="top" colspan="8">
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

	<div id="delete_invoice_modal" ng-show="payment.delete_invoice.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			    <div class="modal-header">
			        Delete Invoice
			    </div>
			    <div class="modal-body">
			        Are you sure you want to delete this invoice?
			    </div>
			    <div class="modal-footer">
			    	<div class="btncon col-md-8 col-md-offset-4 pull-left">
			            {!! Form::button('Yes'
			                , array(
			                    'class' => 'btn btn-blue btn-medium'
			                    , 'ng-click' => 'payment.deleteInvoice(payment.delete_invoice.id)'
			                    , 'data-dismiss' => 'modal'
			                )
			            ) !!}

			            {!! Form::button('No'
			                , array(
			                    'class' => 'btn btn-gold btn-medium'
			                    , 'data-dismiss' => 'modal'
			                )
			            ) !!}
			    	</div>
			    </div>
			</div>
		</div>
	</div>
</div>

<div id="cancel_subscription_modal" ng-show="payment.cancel_invoice.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	        <div class="modal-header">
	            Cancel Subscription
	        </div>
	        <div class="modal-body">
	            Are you sure you want to cancel this subscription?
	        </div>
	        <div class="modal-footer">
	        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
	                {!! Form::button('Yes'
	                    , array(
	                        'class' => 'btn btn-blue btn-medium'
	                        , 'ng-click' => 'payment.cancelInvoice(payment.cancel_invoice.id)'
	                        , 'data-dismiss' => 'modal'
	                    )
	                ) !!}

	                {!! Form::button('No'
	                    , array(
	                        'class' => 'btn btn-gold btn-medium'
	                        , 'data-dismiss' => 'modal'
	                    )
	                ) !!}
	        	</div>
	        </div>
	    </div>
  	</div>
</div>