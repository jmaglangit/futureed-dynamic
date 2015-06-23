<div ng-if="invoice.active_view || invoice.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Invoice</span>
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
		<div class="form-search">
			{!! Form::open(
					array(
						'id' => 'search_form',
						'class' => 'form-horizontal'
					)
			) !!}
				<div class="form-group">
					<div class="col-xs-5"></div>
					<label class="col-xs-3 control-label">Payment Status</label>
					<div class="col-xs-4">
						{!! Form::select('search_status'
							, array(
								  ''=>'-- Select Status --'
								, 'Pending' => 'Pending'
								, 'Paid' => 'Paid'
							 	, 'Cancelled' => 'Cancelled'
						 	)
						 	, null
						 	, array(
						 		'ng-disabled' => 'invoice.active_view'
						 		, 'class' => 'form-control'
						 		, 'ng-model' => 'invoice.record.payment_status'
						 		, 'ng-class' => "{ 'required-field' : invoice.fields['payment_status'] }"
						 		, 'placeholder' => 'Email'
						 	)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Invoice No.</label>
					<div class="col-xs-4">
						{!! Form::text('invoice_no', ''
							, array(
								  'ng-disabled' => 'true'
								, 'class' => 'form-control'
								, 'ng-model' => 'invoice.record.invoice_no'
								, 'placeholder' => 'Invoice No.'
							)
						) !!}
					</div>
					<label class="col-xs-2 control-label">Subscription</label>
					<div class="col-xs-4">
						{!! Form::text('subscription_name', ''
							, array(
								  'ng-disabled' => 'true'
								, 'class' => 'form-control'
								, 'ng-model' => 'invoice.record.subscription.name'
								, 'placeholder' => 'Subscription'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Date Started</label>
					<div class="col-xs-4">
						<input type="text" ng-disabled="true" class="form-control" value="{! invoice.record.date_start | ddMMyyyy !}"/>
					</div>
					<label class="col-xs-2 control-label">Date End</label>
					<div class="col-xs-4">
						<input type="text" ng-disabled="true" class="form-control" value="{! invoice.record.date_end | ddMMyyyy !}"/>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 table-container" ng-init="class.list()">
		<div class="list-container" ng-cloak>
			<div class="title-mid">
				Order List
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
						'ng-model' => 'class.table.size'
						, 'ng-change' => 'class.paginateBySize()'
						, 'ng-if' => "class.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table id="class-list" class="table table-striped table-bordered">
				<thead>
					<tr>
						<td>Number of Seats</td>
						<td>Seats Taken</td>
						<td>Grade</td>
						<td>Teacher</td>
						<td>Class</td>
						<td>Price</td>
					</tr>
				</thead>
	        	<tbody>
					<tr ng-repeat="detail in invoice.record.invoices">
						<td>{! detail.classroom.seats_total !}</td>
						<td>{! detail.classroom.seats_taken !}</td>
						<td>{! detail.grade.name !}</td>
						<td>{! detail.classroom.client.first_name !} {! detail.classroom.client.last_name !}</td>
						<td>{! detail.classroom.name !}</td>
						<td>{! detail.price !}</td>
					</tr>
					<tr class="odd" ng-if="!invoice.record.invoices.length">
						<td valign="top" colspan="6" >
							No records found
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="class.records.length">
				<pagination 
					total-items="class.table.total_items" 
					ng-model="class.table.page"
					max-size="3"
					items-per-page="class.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="class.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="">
			{!! Form::open(
					array(
						'id' => 'search_form',
						'class' => 'form-horizontal'
					)
			) !!}
				<div class="form-group">
					<div class="col-xs-6"></div>
					<label class="col-xs-2 control-label">Sub-total</label>
					<div class="col-xs-4">
						{!! Form::text('subtotal', ''
							, array(
								  'ng-disabled' => 'true'
								, 'class' => 'form-control'
								, 'ng-model' => 'invoice.record.subtotal'
								, 'placeholder' => 'Sub Total'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-6"></div>
					<label class="col-xs-2 control-label">Discount</label>
					<div class="col-xs-4">
						{!! Form::text('discount', ''
							, array(
								  'ng-disabled' => 'true'
								, 'class' => 'form-control'
								, 'ng-model' => 'invoice.record.discount'
								, 'placeholder' => 'Sub Total'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-6"></div>
					<label class="col-xs-2 control-label">Total</label>
					<div class="col-xs-4">
						{!! Form::text('total', ''
							, array(
								  'ng-disabled' => 'true'
								, 'class' => 'form-control'
								, 'ng-model' => 'invoice.record.total'
								, 'placeholder' => 'Sub Total'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-6"></div>
					<div class="col-xs-6 btn-container" ng-if="invoice.active_view">
						{!! Form::button('Edit Status'
		        			, array(
		        				'class' => 'btn btn-blue btn-medium'
		        				, 'ng-click' => "invoice.setActive('edit')"
		        				, 'ng-if' => 'invoice.active_view'
		        			)
		        		) !!}

		        		{!! Form::button('Cancel'
		        			, array(
		        				'class' => 'btn btn-gold btn-medium'
		        				, 'ng-click' => "invoice.setActive()"
		        			)
		        		) !!}
					</div>

					<div class="col-xs-6 btn-container" ng-if="invoice.active_edit">

		        		{!! Form::button('Save Status'
		        			, array(
		        				'class' => 'btn btn-blue btn-medium'
		        				, 'ng-click' => "invoice.updateStatus()"
		        				, 'ng-if' => 'invoice.active_edit'
		        			)
		        		) !!}

		        		{!! Form::button('Cancel'
		        			, array(
		        				'class' => 'btn btn-gold btn-medium'
		        				, 'ng-click' => "invoice.details(invoice.record.invoice_no, 'view')"
		        			)
		        		) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>