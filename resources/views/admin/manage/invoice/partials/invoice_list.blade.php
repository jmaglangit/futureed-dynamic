<div ng-if="invoice.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>Invoice Management</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="invoice.errors || invoice.success">
		<div class="alert alert-error" ng-if="invoice.errors">
			<p ng-repeat="error in invoice.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="invoice.success">
            <p>{! invoice.success !}</p>
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
						, 'ng-submit' => 'invoice.searchFnc($event)'
					]
			) !!}
				<div class="form-group">
					<div class="col-xs-5">
						{!! Form::text('order_no', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'invoice.search.order_no'
								, 'placeholder' => 'Order Number'
							)
						) !!}
					</div>
					<div class="col-xs-5">
						{!! Form::select('payment_status'
							, array(
								'' =>' -- Select Status --'
								, 'Pending'=>'Pending'
								, 'Paid'=>'Paid'
								, 'Cancelled'=> 'Cancelled'
							)
							, null
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'invoice.search.payment_status'
								, 'placeholder' => 'Email')
						) !!}
					</div>
					<div class="col-xs-2">
						<button class="btn btn-blue" type="button" ng-click="invoice.searchFnc($event)">Search</button>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-5">
						{!! Form::text('subscription_name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'invoice.search.subscription_name'
								, 'placeholder' => 'Subscription Name'
							)
						) !!}
					</div>
					<div class="col-xs-5">
						
					</div>
					<div class="col-xs-2">
						<button class="btn btn-gold" type="button" ng-click="invoice.clear()">Clear</button>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 table-container" ng-init="invoice.list()">
		<div class="title-mid">
			Invoice List
		</div>

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
						'ng-model' => 'invoice.table.size'
						, 'ng-change' => 'invoice.paginateBySize()'
						, 'ng-if' => "invoice.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

		<div class="list-container" ng-cloak>
			<table id="invoice-list" class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Order #</th>
			            <th>Subscription Name</th>
			            <th>Date Started</th>
			            <th>Date End</th>
			            <th>Total # of Seats</th>
			            <th>Total Price</th>
			            <th>Status</th>
			            <th ng-if="invoice.records.length">Action</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="invoiceInfo in invoice.records">
			            <td>{! invoiceInfo.order_no !}</td>
			            <td>{! invoiceInfo.subscription.name !}</td>
			            <td>{! invoiceInfo.date_start | ddMMyyyy !}</td>
			            <td>{! invoiceInfo.date_end | ddMMyyyy !}</td>
			            <td>{! invoiceInfo.seats_total !}</td>
			            <td>{! invoiceInfo.total_amount !}</td>
			            <td>{! invoiceInfo.payment_status !}</td>
			            <td ng-if="invoice.records.length">
			            	<div class="row">
			            		<div class="col-xs-6">
			            			<a href="" ng-click="invoice.details(invoiceInfo.id, futureed.ACTIVE_VIEW)"><span><i class="fa fa-eye"></i></span></a>
			            		</div>
			            		<div class="col-xs-6">
			            			<a href="" ng-click="invoice.details(invoiceInfo.id, futureed.ACTIVE_EDIT)"><span><i class="fa fa-pencil"></i></span></a>
			            		</div>
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="!invoice.records.length && !invoice.table.loading">
			        	<td valign="top" colspan="7">
			        		No records found
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="invoice.table.loading">
			        	<td valign="top" colspan="4">
			        		Loading...
			        	</td>
			        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="invoice.records.length">
				<pagination 
					total-items="invoice.table.total_items" 
					ng-model="invoice.table.page"
					max-size="3"
					items-per-page="invoice.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="invoice.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>