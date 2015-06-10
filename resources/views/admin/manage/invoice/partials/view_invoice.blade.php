<div ng-if="invoice.active_view">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Invoice</span>
		</div>
	</div>

	<div class="module-container">
		{!! Form::open(
						[
							'id' => 'invoice',
							'class' => 'form-horizontal'
						]
				) !!}
		<div class="pull-right width-xsmall top-margin">
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
			 		, 'placeholder' => 'Email'
			 	)
			) !!}
		</div>

		<div class="col-xs-12">
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
					{!! Form::select('subscription'
						, array(
							''=>'-- Select Status --'
							, '3 months'=>'3 months'
							, '6 months'=>'6 months'
							, '12 months'=> '12 months'
						)
						, null 
						, array(
							'ng-disabled' => 'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'invoice.record.subscription.name'
						)
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Date Started</label>
				<div class="col-xs-4">
					<input type="text" ng-disabled="true" class="form-control" ng-model="invoice.record.date_start" value="{! invoice.record.date_start | ddMMyyyy !}"/>
				</div>
				<label class="col-xs-2 control-label">Date End</label>
				<div class="col-xs-4">
					<input type="text" ng-disabled="true" class="form-control" ng-model="invoice.record.date_end" value="{! invoice.record.date_end | ddMMyyyy !}"/>
				</div>
			</div>
			<div class="col-xs-12 tab-right">
				<table class="table table-bordered">
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
							<td>{! detail.grade !}</td>
							<td>{! detail.classroom.client.first_name !} {! detail.classroom.client.last_name !}</td>
							<td>{! detail.class_name !}</td>
							<td>{! detail.price !}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="pull-right top-margin">
				<div class="form-group">
					<label class="col-xs-2 control-label">Subtotal</label>
					<div class="col-xs-4">
						{!! Form::text('subtotal', '',['ng-disabled' => 'true','class' => 'form-control', 'ng-model' => 'invoice.record.subtotal', 'placeholder' => 'Sub Total']) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Discount</label>
					<div class="col-xs-4">
						{!! Form::text('subtotal', '',['ng-disabled' => '!invoice.edit','class' => 'form-control', 'ng-model' => 'invoice.record.discount', 'placeholder' => 'Sub Total']) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Total</label>
					<div class="col-xs-4">
						{!! Form::text('subtotal', '',['ng-disabled' => 'true','class' => 'form-control', 'ng-model' => 'invoice.record.total', 'placeholder' => 'Sub Total']) !!}
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-xs-offset-3 top-margin right-div">
					<div class="btn-container">
						<button class="btn btn-blue btn-medium" type="button" ng-show="!invoice.edit_form" ng-click="invoice.setActive('edit')">Edit</button>
						<button class="btn btn-blue btn-medium" type="button" ng-show="invoice.edit_form">Save</button>
						<button class="btn btn-gold btn-medium" type="button" ng-click="invoice.setActive('cancel')">Cancel</button>
					</div>
			</div>
		</div>
	</div>
</div>