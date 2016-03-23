<div ng-if="payment.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.payment_management') !!}</span>
		</div>
	</div>

	<div class="col-xs-12" ng-if="payment.errors || payment.success">
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
			{!! trans('messages.search') !!}
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
							, 'placeholder' => 'trans('messages.admin_order_no')'
							, 'autocomplete' => 'off'
						)
					) !!}
				</div>
				<div class="col-xs-4">
					<select ng-model="payment.search.subscription_name" ng-disabled="!payment.subscriptions.length" ng-init="payment.listSubscription()" class="form-control">
						<option value="">{!! trans('messages.select_subscription') !!}</option>
						<option ng-repeat="subscription in payment.subscriptions" ng-value="subscription.name">{! subscription.name !}</option>
					</select>
				</div>
				<div class="col-xs-2">
					{!! Form::button('trans('messages.search')'
						, array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'payment.searchFnc($event)'
						)
					) !!}
				</div>
				<div class="col-xs-2">
					{!! Form::button('trans('messages.clear')'
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
			<i class="fa fa-plus-square"></i> {!! trans('messages.add_payment') !!}
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.payment_list') !!}
			</div>

			<div class="col-xs-6 size-container">
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

			<table class="col-xs-12 table table-striped table-bordered table-responsive">
				<thead>
			        <tr>
			            <th>{!! trans('messages.admin_order_no') !!}</th>
			            <th>{!! trans('messages.date_started') !!}</th>
			            <th>{!! trans('messages.date_end') !!}</th>
			            <th>{!! trans('messages.total_no_seats') !!}</th>
			            <th>{!! trans('messages.total_price') !!}</th>
			            <th>{!! trans('messages.payment_status') !!}</th>
			            <th ng-if="payment.records.length">{!! trans('messages.action') !!}</th>
			        </tr>
			    </thead>

		        <tbody>
		        <tr ng-repeat="record in payment.records">
		            <td>{! record.order_no !}</td>
		            <td>{! record.date_start | ddMMyy !}</td>
		            <td>{! record.date_end | ddMMyy !}</td>
		            <td>{! record.seats_total !}</td>
		            <td>{! record.total_amount | currency : "USD$ " : 2 !}</td>
		            <td>{! record.payment_status !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-6" title="View">
	    						<a href="" ng-click="payment.paymentDetails(record.id, futureed.ACTIVE_VIEW)"><span><i class="fa fa-eye"></i></span></a>
	    					</div>
	    					<div class="col-xs-6" title="Delete">
	    						<a href="" ng-if="record.payment_status == futureed.PENDING" ng-click="payment.confirmDelete(record.id)"><span><i class="fa fa-trash"></i></span></a>
	    					</div>
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!payment.records.length && !payment.table.loading">
		        	<td valign="top" colspan="8">
		        		{!! trans('messages.no_records_found') !!}
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="payment.table.loading">
		        	<td valign="top" colspan="8">
		        		{!! trans('messages.loading') !!}
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
			        {!! trans('messages.client_delete_invoice') !!}
			    </div>
			    <div class="modal-body">
			        {!! trans('messages.client_delete_invoice_msg') !!}
			    </div>
			    <div class="modal-footer">
			    	<div class="btncon col-md-8 col-md-offset-4 pull-left">
			            {!! Form::button('trans('messages.yes')'
			                , array(
			                    'class' => 'btn btn-blue btn-medium'
			                    , 'ng-click' => 'payment.deleteInvoice(payment.delete_invoice.id)'
			                    , 'data-dismiss' => 'modal'
			                )
			            ) !!}

			            {!! Form::button('trans('messages.no')'
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
	            {!! trans('messages.client_cancel_invoice') !!}
	        </div>
	        <div class="modal-body">
	            {!! trans('messages.client_cancel_invoice_msg') !!}
	        </div>
	        <div class="modal-footer">
	        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
	                {!! Form::button('trans('messages.yes')'
	                    , array(
	                        'class' => 'btn btn-blue btn-medium'
	                        , 'ng-click' => 'payment.cancelInvoice(payment.cancel_invoice.id)'
	                        , 'data-dismiss' => 'modal'
	                    )
	                ) !!}

	                {!! Form::button('trans('messages.no')'
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