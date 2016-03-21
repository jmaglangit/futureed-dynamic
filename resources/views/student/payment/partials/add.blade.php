<div ng-if="payment.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.add_payment') !!}</span>
		</div>
	</div>

	{!! Form::open(array('id'=> 'add_payment_form', 'class' => 'form-horizontal')) !!}
	<div class="form-content col-xs-12" ng-init="payment.checkStudentBillingAddress()">
		<div class="alert alert-error" ng-if="payment.errors">
            <p ng-repeat="error in payment.errors track by $index" > 
              	{! error !}
            </p>
        </div>
		
	<div class="alert alert-error" ng-if="payment.student_billing_address_not_found">
		<p>
			{!! trans('messages.student_update_billing_info') !!} <a href="{{ route('student.profile.index') }}">{!! trans('messages.student_update_now') !!}</a>.
		</p>
	</div>


        <div class="alert alert-success" ng-if="payment.add.success">
        	<p>{!! trans('messages.successful_add_student') !!}</p>
        </div>
        <div class="alert alert-success" ng-if="payment.success">
        	<p>{!! trans('messages.successful_remove_student') !!}</p>
        </div>
        <fieldset class="payment-field">
        	<span class="step">1</span><p class="step-label">{!! trans('messages.please_select_subject') !!}</p>

        	<div class="col-xs-12 search-container">
				<div class="form-search">
		        	<div class="form-group">
		        		<label class="col-xs-2 control-label">{!! trans('messages.subject') !!} <span class="required">*</span></label>
		        		<div class="col-xs-4" ng-init="payment.getSubjects()">
		        			<select class="form-control" id="subject_id" 
		        				name="subject_id" 
		    					ng-disabled="payment.subjects.length <= 0" 
		    					ng-model="payment.invoice.subject_id" 
		    					ng-class="{ 'required-field' : payment.fields['subject_id'] }">
			                        <option value="">{!! trans('messages.select_subject') !!}</option>
			                        <option ng-repeat="subject in payment.subjects" ng-value="subject.id">{! subject.name !}</option>
			                    </select>
		        		</div>
		        	</div>
			    </div>
			</div>
        </fieldset>
        <hr/>
        <fieldset class="payment-field">
        	<span class="step">2</span><p class="step-label">{!! trans('messages.please_select_subscription') !!}</p>
        	
        	<div class="col-xs-12 search-container">
				<div class="form-search">
					<div class="form-group">
						<label class="col-xs-2 control-label">{!! trans('messages.subscription') !!}</label>
						<div class="col-xs-4">
							<select name="subscription" ng-disabled="!payment.subscriptions.length"
									id="subscription" 
									class="form-control"
									ng-change="payment.setSubscription()"
									ng-model="payment.invoice.subscription_id"
									name="subscription_id" 
									ng-class="{ 'required-field' : payment.fields['subscription_id'] }">
		                        <option value="">{!! trans('messages.select_subscription') !!}</option>
		                        <option ng-repeat="subscription in payment.subscriptions" ng-value="{! subscription.id !}">{! subscription.name!}</option>
		                    </select>
						</div>
						<div class="col-xs-6">
							<label class="col-xs-2 control-label">{!! trans('messages.starting') !!}</label>
							<div class="col-xs-4">
								<input type="text" name="start_date" placeHolder="Start Date" ng-disabled="true" class="form-control" value="{! payment.invoice.dis_date_start | ddMMyy !}">
							</div>
							<label class="col-xs-2 control-label">{!! trans('messages.to') !!}</label>
							<div class="col-xs-4">
								<input type="text" name="start_date" placeHolder="End Date" ng-disabled="true" class="form-control" value="{! payment.invoice.dis_date_end | ddMMyy !}">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12">
				<div class="row">
					<div class="col-xs-4 margin-10-bot pull-right">
						<label class="col-xs-4 control-label">{!! trans('messages.subtotal') !!}</label>
						<div>
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">USD$</span>
								<input type="text" ng-disabled="true" class="form-control" value="{! payment.invoice.sub_total | currency : '' : 2 !}" placeholder="Sub Total" />
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4 margin-10-bot pull-right">
						<label class="col-xs-4 control-label">{!! trans('messages.discount') !!}</label>
						<div>
							<div class="input-group">
								{!! Form::text('discount',''
									, [
										'ng-disabled' => true
										, 'class' => 'form-control'
										, 'ng-model' => 'payment.invoice.discount'
										, 'placeholder' => 'trans('messages.discount')'
									]
								) !!}
								<span class="input-group-addon" id="basic-addon1">%</span>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-4 margin-10-bot pull-right">
						<label class="col-xs-4 control-label">{!! trans('messages.total') !!}</label>
						<div>
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">USD$</span>
								<input type="text" ng-disabled="true" class="form-control" value="{! payment.invoice.total_amount | currency : '' : 2 !}" placeholder="Total" />
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12 margin-10-top">
				<div class="btn-container">
					{!! Form::button('trans('messages.delete_subscription')'
						, array(
							'class' => 'btn btn-gold btn-small pull-right'
							, 'ng-click' => "payment.setActive()"
						)
					) !!}
					{!! Form::button('trans('messages.save_subscription')'
						, array(
							'class' => 'btn btn-blue btn-small pull-right'
							, 'ng-click' => "payment.saveSubscription()"
						)
					) !!}
					{!! Form::button('trans('messages.pay_subscription')'
						, array(
							'class' => 'btn btn-blue btn-small pull-right'
							, 'ng-click' => "payment.paySubscription()"
						)
					) !!}
				</div>
			</div>
        </fieldset>
	</div>
	{!! Form::close() !!}
</div>

<div id="cancel_subscription_modal" ng-show="payment.confirm_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            {!! trans('messages.cancel_subscription') !!}
        </div>
        <div class="modal-body">
            {!! trans('messages.save_subscription_msg') !!}
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('{!! trans('messages.yes') !!}'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => "payment.setActive('list')"
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}

                {!! Form::button('{!! trans('messages.no') !!}'
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
            {!! trans('messages.remove_student') !!}
        </div>
        <div class="modal-body">
             {!! trans('messages.are_you_sure_you_want_to_remove_student') !!}
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('trans('messages.yes')'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => "payment.removeStudent('add')"
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}

                {!! Form::button('trans('messages.no')'
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