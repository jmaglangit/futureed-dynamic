<div ng-if="payment.active_view">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Payment</span>
		</div>
	</div>
	{!! Form::open(array('id'=> 'add_payment_form', 'class' => 'form-horizontal')) !!}
	<div class="container form-content">
		<div class="alert alert-error" ng-if="payment.errors">
            <p ng-repeat="error in payment.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="payment.add.success">
        	<p>Successfully added Student</p>
        </div>
        <fieldset ng-if="payment.invoice.payment_status == 'Pending'">
        	<div class="form-group">
        		<label class="col-xs-2 control-label" id="email">Email<span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('Email',''
        				, array(
        					'placeHolder' => 'Email'
        					, 'ng-model' => 'payment.add.email'
        					, 'class' => 'form-control'
        				)
        			) !!}
        		</div>
        		<div class="col-xs-3">
        			<div class="btn-container">
						<button class="btn btn-blue btn-medium margin-0-top" ng-click="payment.addStudentOrderByEmail()" type="button"><span><i class="fa fa-plus-square"></i></span> Add</button>
        			</div>
        		</div>
        	</div>
        	<div class="form-group">
        		<div class="col-xs-8">
        			<center><b>OR</b></center>
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="col-xs-2 control-label" id="name">Name<span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('name',''
        				, array(
        					'placeHolder' => 'Name'
        					, 'ng-model' => 'payment.add.name'
        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
        					, 'ng-change' => "payment.searchName()"
        					, 'class' => 'form-control'
        				)
        			) !!}
        			<div class="angucomplete-holder" ng-if="payment.names">
						<ul class="col-xs-5 angucomplete-dropdown">
							<li class="angucomplete-row" ng-repeat="name in payment.names" ng-click="payment.selectName(name)">
								{! name.first_name !} {! name.last_name !}
							</li>
						</ul>
					</div>
        		</div>
        		<div class="margin-top-8"> 
	                <i ng-if="payment.validation.s_loading" class="fa fa-spinner fa-spin"></i>
	                <span ng-if="payment.validation.s_error" class="error-msg-con">{! payment.validation.s_error !}</span>
	            </div>
        		<div class="col-xs-3">
        			<div class="btn-container">
        				<button class="btn btn-blue btn-medium margin-0-top" ng-click="payment.addStudentOrderByUsername()" type="button"><span><i class="fa fa-plus-square"></i></span> Add</button>
        			</div>
        		</div>
        	</div>
        </fieldset>
		<div class="col-xs-12">
			<div class="col-xs-3 pull-right" ng-if="payment.print">
				{!! Form::button('Print'
					, array(
						'class' => 'btn btn-blue btn-medium pull-right'
						, 'ng-click' => 'payment.print()'
					)
				) !!}
			</div>
			<div class="col-xs-8">
				<div class="col-xs-6">
					<center>
						<i><p>Contact Name : {! payment.client.first_name !} {! payment.client.last_name !}</p>
						<p>Address: {! payment.client.street_address !}</p>
						<p>{! payment.client.city !}</p>
						<p>{! payment.client.state !}</p>
						</i>
					</center>
				</div>
			</div>
			<div class="clearfix"></div>
			{!! Form::open(
					[
						'id' => 'invoice_form',
						'class' => 'form-horizontal'
					]
			) !!}
			<div class="col-xs-10 col-xs-offset-1 margin-top-60">
				<div class="form-group">
					<label class="control-label col-xs-2">Invoice #</label>
					<div class="col-xs-4">
						{!! Form::text('invoice',''
	        				, array(
	        					'placeHolder' => 'Invoice'
	        					, 'ng-model' => 'payment.invoice.id'
	        					, 'class' => 'form-control'
	        					, 'ng-disabled' => 'true'
	        				)
	        			) !!}
					</div>
					<label class="control-label col-xs-2">Subscription</label>
					<div class="col-xs-4">
						<select ng-disabled="!payment.invoice.subscription_enable" name="subscription"
								ng-change="payment.setDate(1)"
								ng-model="payment.no_days"
								id="subscription" 
								class="form-control">
	                        <option value="">-- Select Subscription --</option>
	                        <option ng-repeat="subscription in payment.subscriptions" ng-selected="payment.invoice.subscription.name == subscription.name" data-id="{! subscription.id !}" data-price="{! subscription.price !}" data-name="{! subscription.name!}" value="{! subscription.days !}">{! subscription.name!}</option>
	                    </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Date Started</label>
					<div class="col-xs-4">
						<input type="text" name="start_date" placeHolder="Start Date" ng-disabled="true" class="form-control" value="{! payment.invoice.dis_date_start | ddMMyy !}">
					</div>
					<label class="control-label col-xs-2">Date End</label>
					<div class="col-xs-4">
						<input type="text" name="start_date" placeHolder="End Date" ng-disabled="true" class="form-control" value="{! payment.invoice.dis_date_end | ddMMyy !}">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Payment Status</label>
					<div class="col-xs-4">
						{!! Form::text('invoice',''
	        				, array(
	        					'placeHolder' => 'Status'
	        					, 'ng-model' => 'payment.invoice.payment_status'
	        					, 'class' => 'form-control'
	        					, 'ng-disabled' => 'true'
	        				)
	        			) !!}
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 table-container margin-30-top">
			<div class="list-container" ng-cloak>
				<table class="table table-striped table-bordered">
					<thead>
				        <tr>
				            <th>Name</th>
				            <th>Email</th>
				            <th>Price</th>
				            <th>Actions</th>
				        </tr>
				    </thead>

			        <tbody>
			        <tr ng-repeat="key in payment.students">
			            <td>{! key.student.user.name !}</td>
			            <td>{! key.student.user.email !}</td>
			            <td>{! payment.invoice.price | number: 2 !}</td>
			            <td>
			            	<div class="row">
			            		<div>
		    						<a ng-if="payment.invoice.payment_status != 'Paid'" href="#" ng-click="payment.confirmCancelView(key.id)"><span><i class="fa fa-trash"></i></span></a>
		    					</div>
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="!payment.students.length && !payment.table.loading">
			        	<td valign="top" colspan="7" class="dataTables_empty">
			        		No records found
			        	</td>
			        </tr>
			        <tr class="odd" ng-if="payment.table.loading">
			        	<td valign="top" colspan="7" class="dataTables_empty">
			        		Loading...
			        	</td>
			        </tr>
			        </tbody>
				</table>
			</div>
		</div>
		{!! Form::close() !!}
		{!! Form::open(
				[
					'id' => 'total_form',
					'class' => 'form-horizontal'
				]
		) !!}
		<div class="margin-30-top col-xs-6 pull-right">
			<div class="col-xs-8 pull-right">
				<div class="form-group">
					<label class="control-label col-xs-4">Subtotal</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" placeHolder="Subtotal" value="{! payment.invoice.subtotal | number:2 !}" ng-disabled="true">
					</div>	
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">Discount</label>
					<div class="col-xs-8">
						{!! Form::text('discount',''
	        				, array(
	        					'placeHolder' => 'Discount'
	        					, 'ng-model' => 'payment.invoice.discount'
	        					, 'class' => 'form-control'
	        					, 'ng-disabled' => 'true'
	        				)
	        			) !!}
					</div>	
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">Total</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" placeHolder="Total" value="{! payment.invoice.total_amount | number:2 !}" ng-disabled="true">
					</div>	
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="container margin-30-bot">
		<div class="btn-container margin-30-top">
			{!! Form::button('Delete Subscription'
				, array(
					'class' => 'btn btn-gold btn-small div-right'
					, 'ng-click' => "payment.deleteInvoice(payment.invoice.id)"
					, 'ng-if' => "payment.invoice.payment_status == 'Pending'"
				)
			) !!}
			{!! Form::button('View List'
				, array(
					'class' => 'btn btn-gold btn-small div-right'
					, 'ng-click' => "payment.setActive('list')"
					, 'ng-if' => "payment.invoice.payment_status == 'Paid'"
				)
			) !!}
			{!! Form::button('Renew Subscription'
				, array(
					'class' => 'btn btn-blue btn-small div-right'
					, 'ng-click' => 'payment.renew()'
					, 'ng-if' => "payment.invoice.payment_status == 'Paid'"
					, 'ng-disabled' => 'true'
				)
			) !!}
			{!! Form::button('Save Subscription'
				, array(
					'class' => 'btn btn-blue btn-small div-right'
					, 'ng-click' => "payment.savePayment('view')"
					, 'ng-if' => "payment.invoice.payment_status == 'Pending'"
				)
			) !!}
			{!! Form::button('Pay Subscription'
				, array(
					'class' => 'btn btn-blue btn-small div-right'
					, 'ng-click' => "payment.addPayment('view')"
					, 'ng-if' => "payment.invoice.payment_status == 'Pending'"
				)
			) !!}
		</div>
	</div>
</div>
<div id="remove_subscription_modal_view" ng-show="payment.confirm_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            Remove Student
        </div>
        <div class="modal-body">
            Are you sure you want to remove this student?
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('Yes'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => "payment.removeStudent('view')"
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