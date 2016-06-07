<div ng-if="payment.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.add_payment') !!}</span>
		</div>
	</div>

	{!! Form::open(array('id'=> 'add_payment_form', 'class' => 'form-horizontal')) !!}
		<div class="form-content col-xs-12"  ng-init="payment.getOrderNo()">
			<div class="alert alert-error" ng-if="payment.errors">
	            <p ng-repeat="error in payment.errors track by $index" > 
	              	{! error !}
	            </p>
	        </div>
			
			<div class="alert alert-error" ng-if="payment.billing_address_not_found">
				<p>
					{!! trans('errors.2800') !!} <a href="{!! route('client.profile.index') !!}">{!! trans('messages.student_update_now') !!}</a>.
				</p>
			</div>


	        <div class="alert alert-success" ng-if="payment.success">
	        	<p ng-repeat="success in payment.success track by $index" > 
	        		{! success !}
	            </p>
	        </div>

	        <fieldset class="payment-field">
	        	<span class="step">1</span><p class="step-label">{!! trans('messages.please_select_subject') !!}</p>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">{!! trans('messages.subject') !!} <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			<select class="form-control"
	        				ng-init="payment.getSubject()"
	        				ng-disabled="!payment.subjects.length" 
	        				ng-model="payment.invoice.subject_id" 
	        				ng-class="{ 'required-field' : payment.fields['subject_id'] }">
		                        <option value="">{!! trans('messages.select_subject') !!}</option>
		                        <option ng-repeat="subject in payment.subjects" ng-value="subject.id">{! subject.name !}</option>
		                    </select>
	        		</div>
	        	</div>
	        </fieldset>
	        <hr/>
	        <fieldset class="payment-field">
	        	<span class="step">2</span><p class="step-label">{!! trans('messages.please_select_email') !!}</p>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="email">{!! trans('messages.email') !!} <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('Email',''
	        				, array(
	        					'placeHolder' => trans('messages.email')
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
								type="button"><span><i class="fa fa-plus-square"></i></span> {!! trans('messages.add_student') !!}</button>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<div class="col-xs-8">
	        			<center><b> {!! trans('messages.or') !!} </b></center>
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="name">{!! trans('messages.name') !!} <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('name',''
	        				, array(
	        					'placeHolder' => trans('messages.name')
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
	        					type="button"><span><i class="fa fa-plus-square"></i></span> {!! trans('messages.add_student') !!}</button>
	        			</div>
	        		</div>
	        	</div>
	        </fieldset>
	        <hr/>
	        <fieldset class="payment-field">
	        	<span class="step">3</span><p class="step-label">{!! trans('messages.please_select_subscription') !!}</p>

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
									<option value="">{!! trans('messages.select_subscription') !!}</option>
									<option ng-repeat="subscription in payment.subscriptions" ng-value="{! subscription.id !}">{! subscription.name!}</option>
								</select>
							</div>
							<div class="col-xs-8">
								<label class="col-xs-2 control-label">{!! trans('messages.starting') !!}</label>
								<div class="col-xs-4">
									<input type="text" 
										placeHolder="Start Date" 
										ng-disabled="true"
										ng-class="{ 'required-field' : payment.fields['date_start'] }"
										class="form-control" 
										value="{! payment.invoice.dis_date_start | ddMMyy !}">
								</div>
								<label class="col-xs-2 control-label">{!! trans('messages.to') !!}</label>
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
								<td>{!! trans('messages.name') !!}</td>
								<td>{!! trans('messages.email') !!}</td>
								<td>{!! trans('messages.price') !!}</td>
								<td>{!! trans_choice('messages.action', 1) !!}</td>
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
					        	<td valign="top" colspan="4">
					        		{!! trans('messages.no_records_found') !!}
					        	</td>
					        </tr>
					        <tr class="odd" ng-if="payment.table.loading">
					        	<td valign="top" colspan="4">
					        		{!! trans('messages.loading') !!}
					        	</td>
					        </tr>
						</tbody>
					</table>
				</div>
	        </fieldset>

	        <fieldset class="payment-field">
				<div class="row margin-10-bot">
					<div class="col-xs-6 div-right">
						<label class="col-xs-4 control-label">{!! trans('messages.subtotal') !!}</label>
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
						<label class="col-xs-4 control-label">{!! trans('messages.discount') !!}</label>
						<div class="col-xs-8">
							<div class="input-group">
								{!! Form::text('discount',''
									, [
										'ng-disabled' => true
										, 'class' => 'form-control'
										, 'ng-model' => 'payment.invoice.discount'
										, 'placeholder' => trans('messages.discount')
									]
								) !!}
								<span class="input-group-addon" id="basic-addon1">%</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row margin-10-bot">
					<div class="col-xs-6 div-right">
						<label class="col-xs-4 control-label">{!! trans('messages.total') !!}</label>
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

        	<div class="col-xs-12">
				<div class="btn-container">
					{!! Form::button(trans('messages.pay_subscription')
						, array(
							'class' => 'btn btn-blue btn-semi-medium'
							, 'ng-click' => "payment.addPayment()"
						)
					) !!}

					{!! Form::button(trans('messages.save_subscription')
						, array(
							'class' => 'btn btn-blue btn-semi-medium'
							, 'ng-click' => "payment.savePayment()"
						)
					) !!}

					{!! Form::button(trans('messages.delete_subscription')
						, array(
							'class' => 'btn btn-gold btn-semi-medium'
							, 'ng-click' => "payment.deleteInvoice()"
						)
					) !!}
				</div>
			</div>
		</div>
	{!! Form::close() !!}
</div>

<div id="remove_subscription_modal_add" ng-show="payment.confirm_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            {!! trans('messages.remove_student') !!}
        </div>
        <div class="modal-body">
            {!! trans('messages.are_you_sure_you_want_to_remove_student') !!}
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button(trans('messages.yes')
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => "payment.removeStudent()"
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}

                {!! Form::button(trans('messages.no')
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