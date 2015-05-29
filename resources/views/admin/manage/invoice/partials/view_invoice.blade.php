<div>
	<div class="content-title">
		<div class="title-main-content">
			<span>View Invoice</span>
		</div>
	</div>
	{!! Form::open(
					[
						'id' => 'invoice',
						'class' => 'form-horizontal'
					]
			) !!}
	<div class="right-div top-margin">
		
			{!! Form::select('search_status',[''=>'-- Select Status --','Pending'=>'Pending','Paid'=>'Paid','Cancelled'=> 'Cancelled'],null,['ng-disabled' => '!invoice.edit','class' => 'form-control', 'ng-model' => 'teacher.search_email', 'placeholder' => 'Email']) !!}
	</div>
	<div class="col-xs-12 mid-container">
		<div class="form-group col-xs-10">
			<label class="col-xs-2 control-label">Invoice #</label>
			<div class="col-xs-4">
				{!! Form::text('search_name', '',['ng-disabled' => 'true','class' => 'form-control', 'ng-model' => 'invoice.search_name', 'placeholder' => 'Invoice #']) !!}
			</div>
			<label class="col-xs-2 control-label">Subscription</label>
			<div class="col-xs-4">
				{!! Form::select('search_status',[''=>'-- Select Status --','3 months'=>'3 months','6 months'=>'6 months','12 months'=> '12 months'],null,['ng-disabled' => '!invoice.edit','class' => 'form-control', 'ng-model' => 'teacher.search_email', 'placeholder' => 'Email']) !!}
			</div>
		</div>
		<div class="form-group col-xs-10">
			<label class="col-xs-2 control-label">Date Started</label>
			<div class="col-xs-4">
				{!! Form::text('search_name', '',['ng-disabled' => '!invoice.edit','class' => 'form-control', 'ng-model' => 'invoice.search_name', 'placeholder' => 'Date Started']) !!}
			</div>
			<label class="col-xs-2 control-label">Date End</label>
			<div class="col-xs-4">
				{!! Form::text('search_name', '',['ng-disabled' => '!invoice.edit','class' => 'form-control', 'ng-model' => 'invoice.search_name', 'placeholder' => 'Date Started']) !!}
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
					<tr>
						<td>200</td>
						<td>100</td>
						<td>K1</td>
						<td>Edna Krabappel</td>
						<td>Edna-K1</td>
						<td>25</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="right-div top-margin">
			<div class="form-group">
				<label class="col-xs-2 control-label">Subtotal</label>
				<div class="col-xs-8" style="float:right;">
					{!! Form::text('subtotal', '',['ng-disabled' => 'true','class' => 'form-control', 'ng-model' => 'invoice', 'placeholder' => 'Sub Total']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Discount</label>
				<div class="col-xs-8" style="float:right;">
					{!! Form::text('subtotal', '',['ng-disabled' => '!invoice.edit','class' => 'form-control', 'ng-model' => 'invoice', 'placeholder' => 'Sub Total']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Total</label>
				<div class="col-xs-8" style="float:right;">
					{!! Form::text('subtotal', '',['ng-disabled' => 'true','class' => 'form-control', 'ng-model' => 'invoice', 'placeholder' => 'Sub Total']) !!}
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