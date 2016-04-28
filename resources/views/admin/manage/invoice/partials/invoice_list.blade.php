<div ng-if="invoice.active_list">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_invoice_management') !!}</span>
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
			{!! trans('messages.search') !!}
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
					<div class="col-xs-4">
						{!! Form::text('order_no', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'invoice.search.order_no'
								, 'placeholder' => trans('messages.admin_order_number')
							)
						) !!}
					</div>
					<div class="col-xs-4">
						{!! Form::select('payment_status'
							, array(
								'' =>trans('messages.admin_select_status')
								, 'Pending'=>trans('messages.pending')
								, 'Paid'=>trans('messages.paid')
								, 'Cancelled'=> trans('messages.cancelled')
							)
							, null
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'invoice.search.payment_status'
								, 'placeholder' => trans('messages.email'))
						) !!}
					</div>
					<div class="col-xs-2 invoice-btn">
						<button class="btn btn-blue" type="button" ng-click="invoice.searchFnc($event)">{!! trans('messages.search') !!}</button>
					</div>
					<div class="col-xs-2 invoice-btn">
						<button class="btn btn-gold" type="button" ng-click="invoice.clear()">{!! trans('messages.clear') !!}</button>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="table-container" ng-init="invoice.list()">
		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_invoice_list') !!}
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
						'ng-model' => 'invoice.table.size'
						, 'ng-change' => 'invoice.paginateBySize()'
						, 'ng-if' => "invoice.records.length"
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
			            <th>{!! trans('messages.total_price') !!}</th>
			            <th>{!! trans('messages.status') !!}</th>
			            <th ng-if="invoice.records.length">{!! trans('messages.action') !!}</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="invoiceInfo in invoice.records">
			            <td>{! invoiceInfo.order_no !}</td>
			            <td>{! invoiceInfo.date_start | ddMMyy !}</td>
			            <td>{! invoiceInfo.date_end | ddMMyy !}</td>
			            <td>{! invoiceInfo.seats_total !}</td>
			            <td>{! invoiceInfo.total_amount | currency : "USD$ " : 2 !}</td>
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
			        		{!! trans('messages.no_records_found') !!}
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="invoice.table.loading">
			        	<td valign="top" colspan="4">
			        		{!! trans('messages.loading') !!}
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