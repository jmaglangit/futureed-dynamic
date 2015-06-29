<div ng-if="payment.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Payment</span>
		</div>
	</div>
	{!! Form::open(array('id'=> 'add_payment_form', 'class' => 'form-horizontal')) !!}
	<div class="form-content col-xs-12"  ng-init="payment.getOrderNo()">
		<div class="alert alert-error" ng-if="payment.errors">
            <p ng-repeat="error in payment.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="payment.add.success">
        	<p>Successfully added Student</p>
        </div>
        <div class="alert alert-success" ng-if="payment.success">
        	<p>Successfully removed Student</p>
        </div>
        <fieldset>
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
					<div> 
		                <i ng-if="payment.validation.s_loading" class="fa fa-spinner fa-spin"></i>
		                <span ng-if="payment.validation.s_error" class="error-msg-con">{! payment.validation.s_error !}</span>
		            </div>
        		</div>
        		<div class="col-xs-3">
        			<div class="btn-container">
        				<button class="btn btn-blue btn-medium margin-0-top" ng-click="payment.addStudentOrderByUsername()" type="button"><span><i class="fa fa-plus-square"></i></span> Add</button>
        			</div>
        		</div>
        	</div>
        </fieldset>
	</div>
	{!! Form::close() !!}
	<div class="col-xs-12 search-container">
		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'subscription_form',
						'class' => 'form-horizontal'
					]
			) !!}
			<div class="form-group">
				<label class="col-xs-2 control-label">Subscription</label>
				<div class="col-xs-4">
					<select name="subscription" ng-disabled="!payment.subscriptions.length"
							id="subscription" 
							class="form-control"
							ng-change="payment.setDate(1)"
							ng-model="payment.no_days">
                        <option value="">-- Select Subscription --</option>
                        <option ng-repeat="subscription in payment.subscriptions" data-id="{! subscription.id !}" data-price="{! subscription.price !}" data-name="{! subscription.name !}" value="{! subscription.days !}">{! subscription.name!}</option>
                    </select>
				</div>
				<div class="col-xs-6">
					<label class="col-xs-2 control-label">Starting</label>
					<div class="col-xs-4">
						<input type="text" name="start_date" placeHolder="Start Date" ng-disabled="true" class="form-control" value="{! payment.invoice.dis_date_start | ddMMyy !}">
					</div>
					<label class="col-xs-2 control-label">To</label>
					<div class="col-xs-4">
						<input type="text" name="start_date" placeHolder="End Date" ng-disabled="true" class="form-control" value="{! payment.invoice.dis_date_end | ddMMyy !}">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 table-container margin-top-30">
		<table class="table table-bordered">
			<thead>
				<tr>
					<td>Name</td>
					<td>Email</td>
					<td>Price</td>
					<td>Action</td>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="key in payment.students">
				{{-- Sample Data --}}
					<td>{! key.student.user.name !}</td>
					<td>{! key.student.user.email !}</td>
					<td>{! payment.invoice.price | number: 2 !}</td>
					<td>
						<a href="#" ng-click="payment.confirmCancelAdd(key.id)"><span><i class="fa fa-trash"></i></span></a>
					</td>
				</tr>
				<tr class="odd" ng-if="!payment.students.length && !payment.table.loading">
		        	<td valign="top" colspan="4" class="dataTables_empty">
		        		No records found
		        	</td>
		        </tr>
		        <tr class="odd" ng-if="payment.table.loading">
		        	<td valign="top" colspan="4" class="dataTables_empty">
		        		Loading...
		        	</td>
		        </tr>
			</tbody>
		</table>
	</div>
	<div class="col-xs-12">
		<div class="row margin-10-bot">
			<div class="col-xs-4 div-right">
				<label class="col-xs-4 control-label">Sub Total</label>
				<div class="col-xs-8">
					<input type="text" class="form-control" placeHolder="Subtotal" value="{! payment.invoice.subtotal | number:2 !}" ng-disabled="true">
				</div>
			</div>
		</div>
		<div class="row margin-10-bot">
			<div class="col-xs-4 div-right">
				<label class="col-xs-4 control-label">Discount</label>
				<div class="col-xs-8">
					{!! Form::text('discount',''
        				, array(
        					'placeHolder' => 'Discount'
        					, 'ng-model' => 'payment.discount.percentage'
        					, 'class' => 'form-control'
        					, 'ng-disabled' => 'true'
        				)
        			) !!}
				</div>
			</div>
		</div>
		<div class="row margin-10-bot">
			<div class="col-xs-4 div-right">
				<label class="col-xs-4 control-label">Total</label>
				<div class="col-xs-8">
					<input type="text" class="form-control" placeHolder="Total" value="{! payment.invoice.total_amount | number:2 !}" ng-disabled="true">
				</div>
			</div>
		</div>
	</div>	
	<div class="col-xs-12 margin-30-bot">
		<div class="container">
		<div class="btn-container margin-30-top">
			{!! Form::button('Delete Subscription'
				, array(
					'class' => 'btn btn-gold btn-small div-right'
					, 'ng-click' => "payment.deleteInvoice(payment.invoice_detail.id)"
				)
			) !!}
			{!! Form::button('Save Subscription'
				, array(
					'class' => 'btn btn-blue btn-small div-right'
					, 'ng-click' => "payment.savePayment('add')"
				)
			) !!}
			{!! Form::button('Pay Subscription'
				, array(
					'class' => 'btn btn-blue btn-small div-right'
					, 'ng-click' => "payment.addPayment('add')"
				)
			) !!}
		</div>
	</div>
	</div>
</div>

<div id="cancel_subscription_modal" ng-show="payment.confirm_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            Cancel Subscription
        </div>
        <div class="modal-body">
            Your changes will be saved. Are you sure you want to cancel this subscription?
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('Yes'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => "payment.setActive('list')"
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

<div id="remove_subscription_modal_add" ng-show="payment.confirm_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                        , 'ng-click' => "payment.removeStudent('add')"
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