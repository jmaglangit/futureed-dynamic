<div ng-if="payment.active_view">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Payment</span>
		</div>
	</div>
	{!! Form::open(array('id'=> 'add_payment_form', 'class' => 'form-horizontal')) !!}
	<div class="col-xs-12 form-content">
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

        <div ng-if="payment.invoice.payment_status == futureed.PENDING">
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
							<option ng-selected="payment.invoice.subject_id == subject.id" 
								ng-repeat="subject in payment.subjects" 
								ng-value="subject.id">{! subject.name !}</option>
						</select>
					</div>
				</div>
			</fieldset>

			<hr/>

			<fieldset class="payment-field">
				<span class="step">2</span><p class="step-label">Please select an email or a name of a student.</p>
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
							<button class="btn btn-blue margin-0-top" 
								ng-click="payment.addStudentOrderByEmail()" 
								ng-disabled="!payment.invoice.subject_id"
								type="button">
								<span><i class="fa fa-plus-square"></i></span> Add Student </button>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-8">
						<center><b> OR </b></center>
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
							<button class="btn btn-blue margin-0-top" 
								ng-click="payment.addStudentOrderByUsername()" 
								ng-disabled="!payment.invoice.subject_id"
								type="button">
								<span><i class="fa fa-plus-square"></i></span> Add Student 
							</button>
						</div>
					</div>
				</div>
			</fieldset>

			<hr/>
			<fieldset class="payment-field">
				<span class="step">3</span><p class="step-label">Please select a subscription.</p>
			</fieldset>
        </div>
        
        <div ng-if="payment.invoice.payment_status == futureed.PAID">
        	<div class="col-xs-3 pull-right" ng-if="payment.print">
				{!! Form::button('Print'
					, array(
						'class' => 'btn btn-blue btn-medium pull-right'
						, 'ng-click' => 'payment.print()'
					)
				) !!}
			</div>

			<fieldset class="payment-field">
				<div class="col-xs-12">
					<div>
						{!! Form::open(
						[
						'id' => 'search_form',
						'class' => 'form-horizontal'
						]
						) !!}
							<div ng-if="payment.invoice.payment_status == futureed.PAID">
								<h4>BILLING INVOICE</h4>
								<div class="invoice-group">
									<p>Ref: {! payment.client.first_name !} {! payment.client.last_name !} {! payment.invoice.id !} / {!! date('Y') !!}</p>
								</div>
								<div class="invoice-group">
									<p>Date : {{ date('d/m/Y') }}</p>
								</div>
								<div class="invoice-group">
									<p class="bill-info">{! payment.client.first_name !} {! payment.client.last_name !}
									<p class="bill-info">{! payment.client.street_address !}</p>
									<p class="bill-info">{! payment.client.city !} {! payment.client.state !} {! payment.client.zip !}</p>
									<p class="bill-info">{! payment.client.country !}</p>
								</div>
								<div class="invoice-group">
									<p class="bill-info">Bill to:</p>
									<p class="bill-info">{! futureed.BILL_COMPANY !}</p>
									<p class="bill-info">{! futureed.BILL_STREET !}</p>
									<p class="bill-info">{! futureed.BILL_ADDRESS !}</p>
									<p class="bill-info">{! futureed.BILL_COUNTRY !}</p>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</fieldset>

			<hr />
        </div>
        
        <fieldset class="payment-field">
			<div class="col-xs-12">
				<div class="form-search">
					<div class="form-group">
						<div class="col-xs-4" ng-if="payment.invoice.payment_status == futureed.PAID">
							<select class="form-control" 
								ng-init="payment.getSubject()"
								ng-disabled="true" 
								ng-model="payment.invoice.subject_id" 
								ng-class="{ 'required-field' : payment.fields['subject_id'] }">
								<option value="">-- Select Subject --</option>
								<option ng-selected="payment.invoice.subject_id == subject.id" 
									ng-repeat="subject in payment.subjects" 
									ng-value="subject.id">{! subject.name !}</option>
							</select>
						</div>

						<label class="control-label col-xs-3">Payment Status</label>
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

					<div class="form-group">
						<div class="col-xs-4">
							<select ng-disabled="!payment.subscriptions.length || payment.invoice.payment_status == futureed.PAID"
								ng-change="payment.setSubscription()"
								ng-model="payment.invoice.subscription_id"
								class="form-control"
								ng-class="{ 'required-field' : payment.fields['subscription_id'] }">
								<option value="">-- Select Subscription --</option>
								<option ng-repeat="subscription in payment.subscriptions" 
									ng-selected="payment.invoice.subscription_id == subscription.id" 
									value="{! subscription.id !}">{! subscription.name!}</option>
							</select>
						</div>

						<div class="col-xs-8">
							<label class="control-label col-xs-2">Starting</label>
							<div class="col-xs-4">
								<input type="text" 
									placeholder="Start Date" 
									ng-disabled="true" 
									class="form-control" 
									value="{! payment.invoice.dis_date_start | ddMMyy !}" />
							</div>

							<label class="control-label col-xs-2">To</label>
							<div class="col-xs-4">
								<input type="text" 
									placeholder="End Date" 
									ng-disabled="true" 
									class="form-control" 
									value="{! payment.invoice.dis_date_end | ddMMyy !}" />
							</div>
						</div>
					</div>
				</div>
			</div>
        </fieldset>
        
        <fieldset class="payment-field">
			<div class="col-xs-12">
				<div class="list-container" ng-cloak>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Price</th>
								<th ng-if="payment.invoice.payment_status == futureed.PENDING">Action</th>
							</tr>
						</thead>

						<tbody>
							<tr ng-repeat="student in payment.students">
								<td>{! student.student.user.name !}</td>
								<td>{! student.student.user.email !}</td>
								<td>{! student.price | currency : '' : 2 !}</td>
								<td ng-if="payment.invoice.payment_status == futureed.PENDING">
									<div class="row">
										<div>
											<a href="javascript:void(0)" ng-click="payment.confirmCancelAdd(student.id)"><span><i class="fa fa-trash"></i></span></a>
										</div>
									</div>
								</td>
							</tr>
							<tr class="odd" ng-if="!payment.students.length && !payment.table.loading">
								<td valign="top" colspan="7">
									No records found
								</td>
							</tr>
							<tr class="odd" ng-if="payment.table.loading">
								<td valign="top" colspan="7">
									Loading...
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
        </fieldset>

        <fieldset class="payment-field">
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
        </fieldset>

		<div ng-if="payment.invoice.payment_status == futureed.PAID">
			<fieldset class="payment-field">
				<div class="col-xs-12">
					<div class="invoice-group">
						<p>No signature required.<br/>
						Electronic Invoice</p>
					</div>
					<div class="invoice-group">
						<p>Payment Methods:<br/>
						Direct Credit to: {! futureed.CC_NAME !}<br/>
						Bank Name: {! futureed.BANK_NAME !}<br/>
						Bank Account Number: <br/>
						{! futureed.BANK_ACCT_NO_SGD !}<br/>
						{! futureed.BANK_ACCT_NO_USD !}<br/>
						Bank Address: {! futureed.BANK_ADDRESS !}<br/>
						Bank Code: {! futureed.BANK_CODE !}
						</p>
					</div>
				</div>
			</fieldset>
		</div>

		<hr/>
		<div class="col-xs-12">
			<div class="btn-container">
				{!! Form::button('Delete Subscription'
					, array(
						'class' => 'btn btn-gold btn-semi-medium div-right'
						, 'ng-click' => "payment.deleteInvoice()"
						, 'ng-if' => "payment.invoice.payment_status == futureed.PENDING"
					)
				) !!}
				{!! Form::button('View List'
					, array(
						'class' => 'btn btn-gold btn-semi-medium div-right'
						, 'ng-click' => "payment.setActive()"
						, 'ng-if' => "payment.invoice.payment_status != futureed.PENDING"
					)
				) !!}
				{!! Form::button('Renew Subscription'
					, array(
						'class' => 'btn btn-blue btn-semi-medium div-right'
						, 'ng-click' => 'payment.renew()'
						, 'ng-if' => "payment.invoice.payment_status == futureed.PAID"
						, 'ng-disabled' => 'true'
					)
				) !!}
				{!! Form::button('Save Subscription'
					, array(
						'class' => 'btn btn-blue btn-semi-medium div-right'
						, 'ng-click' => "payment.savePayment()"
						, 'ng-if' => "payment.invoice.payment_status == futureed.PENDING"
					)
				) !!}
				{!! Form::button('Pay Subscription'
					, array(
						'class' => 'btn btn-blue btn-semi-medium div-right'
						, 'ng-click' => "payment.addPayment()"
						, 'ng-if' => "payment.invoice.payment_status == futureed.PENDING"
					)
				) !!}
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
</div>