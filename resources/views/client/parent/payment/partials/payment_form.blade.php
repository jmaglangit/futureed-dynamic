<div ng-if="payment.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.payment_management') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="payment.errors || payment.success">
		<div class="alert alert-error" ng-if="payment.errors">
            <p ng-repeat="error in payment.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="payment.success">
			<p ng-repeat="success in payment.success track by $index" > 
				{! success !}
			</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			{!! trans('messages.search') !!}
		</div>

		<div class="form-search">
			{!! Form::open(
					array(
						'id' => 'teacher_search',
						'class' => 'form-horizontal'
					)
			) !!}
			<div class="form-group">
				<div class="col-xs-4">
					{!! Form::text('search_order'
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'payment.search.order_no'
							, 'placeholder' => 'trans('messages.admin_order_number')'
						)
					) !!}
				</div>
				<div class="col-xs-4">
					<select ng-model="payment.search.subscription_name" ng-disabled="!payment.subscriptions.length" ng-init="payment.getSubscriptionList()"
							class="form-control">
	                    <option value="">{!! trans('messages.select_subscription') !!}</option>
	                    <option ng-repeat="subscription in payment.subscriptions" ng-value="subscription.name">{! subscription.name!}</option>
	                </select>
				</div>
				<div class="col-xs-2">
					{!! Form::button('trans('messages.search')'
						, array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'payment.searchFnc()'
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
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 table-container" ng-init="payment.list()">
		<button class="btn btn-blue btn-semi-medium" ng-click="payment.checkBillingAddress();payment.setActive(futureed.ACTIVE_ADD)">
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

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>{!! trans('messages.admin_order_no') !!}</th>
			            <th>{!! trans('messages.date_started') !!}</th>
			            <th>{!! trans('messages.date_end') !!}</th>
			            <th>{!! trans('messages.total_no_seats') !!}</th>
			            <th>{!! trans('messages.status') !!}</th>
			            <th>{!! trans('messages.total_price') !!}</th>
			            <th ng-if="payment.records.length">{!! trans('messages.action') !!}</th>
			        </tr>
			    </thead>

		        <tbody>
		        <tr ng-repeat="invoice in payment.records">
		            <td>{! invoice.order_no !}</td>
		            <td>{! invoice.date_start | ddMMyy !}</td>
		            <td>{! invoice.date_end | ddMMyy !}</td>
		            <td>{! invoice.seats_total !}</td>
		            <td>{! invoice.payment_status !}</td>
		            <td>{! invoice.total_amount | currency : 'USD$ ' : 2 !}</td>
		            <td>
						<div class="row">
							<div class="col-xs-6">
								<a href="" ng-click="payment.setActive(futureed.ACTIVE_VIEW, invoice.id)" title="view"><span><i class="fa fa-eye"></i></span></a>
							</div>
							<div class="col-xs-6">
								<a href="" ng-if="invoice.payment_status == futureed.PENDING" ng-click="payment.confirmDelete(invoice.id)" title="delete"><span><i class="fa fa-trash"></i></span></a>
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

	<div id="invoice_modal" ng-show="payment.confirm_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					{!! trans('messages.remove_invoice') !!}
				</div>
			
				<div class="modal-body">
					{!! trans('messages.are_you_sure_you_want_to_remove_invoice') !!}
				</div>
				
				<div class="modal-footer">
					<div class="btncon col-md-8 col-md-offset-4 pull-left">
						{!! Form::button('{!! trans('messages.yes') !!}'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "payment.deleteInvoice(payment.invoice_id)"
								, 'data-dismiss' => 'modal'
							)
						) !!}

						{!! Form::button('{!! trans('messages.no') !!}'
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