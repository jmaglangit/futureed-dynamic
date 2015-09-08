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

	        <div class="alert alert-success" ng-if="payment.success">
	        	<p ng-repeat="success in payment.success track by $index" > 
	        		{! success !}
	            </p>
	        </div>

	        <fieldset class="payment-field">
	        	<span class="step">1</span><p class="step-label">Please select a subject.</p>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">Subject <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			<select class="form-control"
	        				ng-init="payment.getSubject()"
	        				ng-disabled="!payment.subjects.length" 
	        				ng-model="payment.invoice.subject_id" 
	        				ng-class="{ 'required-field' : payment.fields['subject_id'] }">
		                        <option value="">-- Select Subject --</option>
		                        <option ng-repeat="subject in payment.subjects" ng-value="subject.id">{! subject.name !}</option>
		                    </select>
	        		</div>
	        	</div>
	        </fieldset>
	        <hr/>
	        <fieldset class="payment-field">
	        	<span class="step">2</span><p class="step-label">Please select an email or a name of a student.</p>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="email">Email <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('Email',''
	        				, array(
	        					'placeHolder' => 'Email'
	        					, 'ng-model' => 'payment.add.email'
	        					, 'class' => 'form-control'
	        					, 'autocomplete' => 'off'
	        				)
	        			) !!}
	        		</div>
	        		<div class="col-xs-3">
	        			<div class="btn-container">
							<button class="btn btn-blue margin-0-top" 
								ng-disabled="!payment.invoice.subject_id"
								ng-click="payment.addStudentOrderByEmail()" 
								type="button"><span><i class="fa fa-plus-square"></i></span> Add Student</button>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<div class="col-xs-8">
	        			<center><b> OR </b></center>
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="name">Name <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('name',''
	        				, array(
	        					'placeHolder' => 'Name'
	        					, 'ng-model' => 'payment.add.name'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => "payment.searchName()"
	        					, 'class' => 'form-control'
	        					, 'autocomplete' => 'off'
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
	        				<button class="btn btn-blue margin-0-top" 
	        					ng-disabled="!payment.invoice.subject_id"
	        					ng-click="payment.addStudentOrderByUsername()" 
	        					type="button"><span><i class="fa fa-plus-square"></i></span> Add Student</button>
	        			</div>
	        		</div>
	        	</div>
	        </fieldset>
	        <hr/>
	        <fieldset class="payment-field">
	        	<span class="step">3</span><p class="step-label">Please select a subscription.</p>

	        	<div class="col-xs-12">
		        	<div class="form-search">
						<div class="form-group">
							<div class="col-xs-4">
								<select class="form-control" 
										ng-init="payment.getSubscriptionList()"
										ng-disabled="!payment.subscriptions.length"
										ng-change="payment.setSubscription()"
										ng-model="payment.invoice.subscription_id"
										ng-class="{ 'required-field' : payment.fields['subscription_id'] }">
			                        <option value="">-- Select Subscription --</option>
			                        <option ng-repeat="subscription in payment.subscriptions" ng-value="{! subscription.id !}">{! subscription.name!}</option>
			                    </select>
							</div>
							<div class="col-xs-8">
								<label class="col-xs-2 control-label">Starting</label>
								<div class="col-xs-4">
									<input type="text" 
										placeHolder="Start Date" 
										ng-disabled="true"
										ng-class="{ 'required-field' : payment.fields['date_start'] }"
										class="form-control" 
										value="{! payment.invoice.dis_date_start | ddMMyy !}">
								</div>
								<label class="col-xs-2 control-label">To</label>
								<div class="col-xs-4">
									<input type="text"
										placeHolder="End Date"
										ng-class="{ 'required-field' : payment.fields['date_end'] }"
										ng-disabled="true"
										class="form-control"
										value="{! payment.invoice.dis_date_end | ddMMyy !}">
								</div>
							</div>
						</div>
					</div>
				</div>
	        </fieldset>

	        <fieldset class="payment-field">
	        	<div class="col-xs-12">
					<table class="table table-bordered table-condensed table-striped">
						<thead>
							<tr>
								<td>Name</td>
								<td>Email</td>
								<td>Price</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="student in payment.students">
								<td>{! student.student.user.name !}</td>
								<td>{! student.student.user.email !}</td>
								<td>{! student.price | currency : 'USD$ ' : 2 !}</td>
								<td>
									<a href="javascript:void(0)" ng-click="payment.confirmCancelAdd(student.id)"><span><i class="fa fa-trash"></i></span></a>
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
	        </fieldset>

	        <fieldset class="payment-field">
	        	<div>
					<div class="row margin-10-bot">
						<div class="col-xs-6 div-right">
							<label class="col-xs-4 control-label">Subtotal</label>
							<div class="col-xs-8">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">USD$</span>
									<input type="text" 
										ng-disabled="true" 
										class="form-control" 
										value="{! payment.invoice.sub_total | currency : '' : 2 !}" 
										placeholder="Subtotal" />
								</div>
							</div>
						</div>
					</div>
					<div class="row margin-10-bot">
						<div class="col-xs-6 div-right">
							<label class="col-xs-4 control-label">Discount</label>
							<div class="col-xs-8">
								<div class="input-group">
									{!! Form::text('discount',''
										, [
											'ng-disabled' => true
											, 'class' => 'form-control'
											, 'ng-model' => 'payment.invoice.discount'
											, 'placeholder' => 'Discount'
										]
									) !!}
									<span class="input-group-addon" id="basic-addon1">%</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row margin-10-bot">
						<div class="col-xs-6 div-right">
							<label class="col-xs-4 control-label">Total</label>
							<div class="col-xs-8">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">USD$</span>
									<input type="text" 
										ng-disabled="true" 
										class="form-control" 
										value="{! payment.invoice.total_amount | currency : '' : 2 !}" 
										placeholder="Total" />
								</div>
							</div>
						</div>
					</div>
				</div>
	        </fieldset>

        	<div class="col-xs-12">
				<div class="btn-container">
					{!! Form::button('Pay Subscription'
						, array(
							'class' => 'btn btn-blue btn-semi-medium'
							, 'ng-click' => "payment.addPayment('add')"
						)
					) !!}

					{!! Form::button('Save Subscription'
						, array(
							'class' => 'btn btn-blue btn-semi-medium'
							, 'ng-click' => "payment.savePayment('add')"
						)
					) !!}

					{!! Form::button('Delete Subscription'
						, array(
							'class' => 'btn btn-gold btn-semi-medium'
							, 'ng-click' => "payment.deleteInvoice(payment.invoice_detail.id)"
						)
					) !!}
				</div>
			</div>
		</div>
	{!! Form::close() !!}
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
                        , 'ng-click' => "payment.removeStudent()"
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