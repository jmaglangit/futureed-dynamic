<div ng-if="payment.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Payment Management</span>
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
						<option ng-repeat="subscription in payment.subscriptions" value="{! subscription.name !}">{! subscription.name !}</option>
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
		<button class="btn btn-blue btn-small" ng-click="payment.setActive('add')">
			<i class="fa fa-plus-square"></i> Add 
		</button>

		<div class="title-mid">
			Payment List
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
						'ng-model' => 'payment.table.size'
						, 'ng-change' => 'payment.paginateBySize()'
						, 'ng-if' => "payment.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="table table-striped table-bordered table-responsive">
				<thead>
			        <tr>
			            <th>Order #</th>
			            <th>Subscription Name</th>
			            <th>Date Started</th>
			            <th>Date End</th>
			            <th>Total # of Seats</th>
			            <th>Total Price</th>
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
		            <td>
		            	<div class="row">
		            		<div class="col-xs-12">
	    						<a href="" ng-click="payment.paymentDetails(record.id, futureed.ACTIVE_VIEW)"><span><i class="fa fa-eye"></i></span></a>
	    					</div>
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!payment.records.length && !payment.table.loading">
		        	<td valign="top" colspan="7">
		        		No records found
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="payment.table.loading">
		        	<td valign="top" colspan="7">
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