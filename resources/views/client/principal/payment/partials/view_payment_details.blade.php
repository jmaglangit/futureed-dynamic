<div ng-if="payment.active_view || payment.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Invoice</span>
		</div>
	</div>

	<div class="module-container">
		<div class="pull-right width-small table-container">
			{!! Form::select('search_status'
				, array(
					  ''=>'-- Select Status --'
					, 'Pending' => 'Pending'
					, 'Paid' => 'Paid'
				 	, 'Cancelled' => 'Cancelled'
			 	)
			 	, null
			 	, array(
			 		'ng-disabled' => 'payment.active_view'
			 		, 'class' => 'form-control'
			 		, 'ng-model' => 'payment.record.payment_status'
			 		, 'placeholder' => 'Email'
			 	)
			) !!}
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
						<label class="col-xs-2 control-label">Invoice No.</label>
						<div class="col-xs-4">
							{!! Form::text('invoice_no', ''
								, array(
									  'ng-disabled' => 'true'
									, 'class' => 'form-control'
									, 'ng-model' => 'payment.record.id'
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
									, 'ng-model' => 'payment.record.subscription.name'
									, 'placeholder' => 'Subscription'
								)
							) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-2 control-label">Date Started</label>
						<div class="col-xs-4">
							<input type="text" ng-disabled="true" class="form-control" value="{! payment.record.date_start | ddMMyyyy !}"/>
						</div>
						<label class="col-xs-2 control-label">Date End</label>
						<div class="col-xs-4">
							<input type="text" ng-disabled="true" class="form-control" value="{! payment.record.date_end | ddMMyyyy !}"/>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>

		<div class="col-xs-12 table-container" ng-init="payment.listInvoiceDetails(payment.record.id)">
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
							'ng-model' => 'payment.table.size'
							, 'ng-change' => 'payment.paginateBySize()'
							, 'ng-if' => "payment.records.length"
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
						<tr ng-repeat="record in payment.records">
							<td>{! record.classroom.seats_total !}</td>
							<td>{! record.classroom.seats_taken !}</td>
							<td>{! record.grade.name !}</td>
							<td>{! record.classroom.client.first_name !} {! record.classroom.client.last_name !}</td>
							<td>{! record.classroom.name !}</td>
							<td>{! record.price !}</td>
						</tr>
						<tr class="odd" ng-if="!invoice.record.invoices.length">
							<td valign="top" colspan="6" >
								No records found
							</td>
						</tr>
					</tbody>
				</table>

				<div class="pull-right" ng-if="payment.records.length">
					<pagination 
						total-items="payment.table.total_items" 
						ng-model="payment.table.page"
						max-size="3"
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
									, 'ng-model' => 'payment.record.subtotal'
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
									, 'ng-model' => 'payment.record.discount'
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
									, 'ng-model' => 'payment.record.total_amount'
									, 'placeholder' => 'Sub Total'
								)
							) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-6"></div>
						<div class="col-xs-6 btn-container">
							{!! Form::button('Edit Status'
			        			, array(
			        				'class' => 'btn btn-blue btn-medium'
			        				, 'ng-click' => "payment.setActive('edit')"
			        			)
			        		) !!}

			        		{!! Form::button('Cancel'
			        			, array(
			        				'class' => 'btn btn-gold btn-medium'
			        				, 'ng-click' => "payment.setActive()"
			        			)
			        		) !!}
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>