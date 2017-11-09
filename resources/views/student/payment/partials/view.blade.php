<div ng-if="payment.active_view">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.client_view_sales_invoice') !!}</span>
		</div>
	</div>

	<div ng-if="payment.invoice.payment_status == futureed.PENDING">
		{!! Form::open(array('id'=> 'add_payment_form', 'class' => 'form-horizontal')) !!}
			<div class="form-content col-xs-12" ng-init="payment.getSchoolCode()">
				<div class="alert alert-error" ng-if="payment.errors">
		            <p ng-repeat="error in payment.errors track by $index" > 
		              	{! error !}
		            </p>
		        </div>

		        <div class="alert alert-success" ng-if="payment.success">
		        	<p>{! payment.success !}</p>
		        </div>
		        <fieldset class="payment-field">
		        	<span class="step">1</span><p class="step-label">{!! trans('messages.please_select_subject') !!}</p>
		        	<div class="col-xs-12 search-container">
						<div class="form-search">
							{!! Form::open(
									[
										'id' => 'principal-payment',
										'class' => 'form-horizontal'
										, 'ng-submit' => 'payment.searchFnc($event)'
									]
							) !!}
					        	<div class="form-group">
					        		<label class="col-xs-2 control-label">{!! trans('messages.subject') !!} <span class="required">*</span></label>
					        		<div class="col-xs-4" ng-init="payment.getSubjects()">
					        			<select class="form-control" id="subject_id" name="subject_id" ng-disabled="payment.subjects.length <= 0" ng-model="payment.invoice.subject_id" ng-class="{ 'required-field' : payment.fields['subject_id'] }">
						                        <option value="">{!! trans('messages.select_subject') !!}</option>
						                        <option ng-selected="payment.invoice.subject_id == subject.id" ng-repeat="subject in payment.subjects" ng-value="subject.id">{! subject.name !}</option>
						                    </select>
					        		</div>
					        	</div>
					        {!! Form::close() !!}
						</div>
					</div>
		        </fieldset>
		        <hr/>
		        <fieldset class="payment-field">
		        	<span class="step">2</span><p class="step-label">{!! trans('messages.please_select_subscription') !!}</p>
		        	<div class="col-xs-12 search-container">
						<div class="form-search">
							{!! Form::open(
									[
										'id' => 'principal-payment',
										'class' => 'form-horizontal'
										, 'ng-submit' => 'payment.searchFnc($event)'
									]
							) !!}
							<div class="form-group">
								<label class="col-xs-2 control-label">{!! trans('messages.payment_status') !!}</label>
								<div class="col-xs-4">
									{!! Form::text('name',''
				        				, array(
				        					'placeHolder' => trans('messages.payment_status')
				        					, 'ng-model' => 'payment.invoice.payment_status'
				        					, 'ng-disabled' => 'true'
				        					, 'class' => 'form-control'
				        				)
				        			) !!}
								</div>
								<div class="col-xs-6"></div>
							</div>
							<div class="form-group">
								<label class="col-xs-2 control-label">{!! trans('messages.subscription') !!}</label>
								<div class="col-xs-4">
									<select ng-model="payment.invoice.subscription_id" 
										ng-disabled="!payment.subscriptions.length || payment.invoice.payment_status !== futureed.PENDING" 
										ng-init="payment.listSubscription()"
										ng-change="payment.setSubscription()" class="form-control" name="subscription_id" ng-class="{ 'required-field' : payment.fields['subscription_id'] }">

										<option value="">{!! trans('messages.select_subscription') !!}</option>
										<option ng-selected="payment.invoice.subscription_id == subscription.id" ng-repeat="subscription in payment.subscriptions" ng-value="subscription.id">{! subscription.name !}</option>
									</select>
								</div>
								<div class="col-xs-6">
									<label class="col-xs-2 control-label">{!! trans('messages.starting') !!}</label>
									<div class="col-xs-4">
										<input class="form-control" ng-disabled="true" value="{! payment.invoice.dis_date_start | ddMMyy !}" placeholder="DD/MM/YY" />
									</div>
									<label class="col-xs-2 control-label">{!! trans('messages.to') !!}</label>
									<div class="col-xs-4">
										<input class="form-control" ng-disabled="true" value="{! payment.invoice.dis_date_end | ddMMyy !}" placeholder="DD/MM/YY" />
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
												, 'placeholder' => trans('messages.discount')
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
		        </fieldset>
			</div>
		{!! Form::close() !!}
	</div>

	<div class="clearfix"></div>

	<div class="search-container" ng-if="payment.invoice.payment_status == futureed.PAID || payment.invoice.payment_status == futureed.CANCELLED">
		<div class="alert alert-error" ng-if="payment.errors">
            <p ng-repeat="error in payment.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="payment.success">
        	<p>{! payment.success !}</p>
        </div>

		<h4>{!! trans('messages.billing_invoice') !!}</h4>
		<div class="invoice-group">
			<p>Ref: {! payment.invoice.client_name !} {! payment.invoice.id !} / {!! date('Y') !!}</p>
		</div>
		<div class="invoice-group">
			<p>{!! trans('messages.date') !!} : {{ date('d/m/Y') }}</p>
		</div>
		<div class="invoice-group margin-10-bot">
			<p class="bill-info">{! payment.invoice.client_name !}</p>
			<p class="bill-info">{! payment.user.street_address !}</p>
			<p class="bill-info">{! payment.user.city !}</p>
			<p class="bill-info">{! payment.user.state !}</p>
		</div>
		<div class="invoice-group">
			<p class="bill-info">{!! trans('messages.bill_to') !!}</p>
			<p class="bill-info">{! futureed.BILL_COMPANY !}</p>
			<p class="bill-info">{! futureed.BILL_STREET !}</p>
			<p class="bill-info">{! futureed.BILL_ADDRESS !}</p>
			<p class="bill-info">{! futureed.BILL_COUNTRY !}</p>
		</div>

		<hr />
		<div class="col-xs-12 search-container">
			<div class="form-search">
				{!! Form::open(
						[
							'id' => 'principal-payment',
							'class' => 'form-horizontal'
							, 'ng-submit' => 'payment.searchFnc($event)'
						]
				) !!}
				<div class="form-group">
					<label class="col-xs-2 control-label">{!! trans('messages.subject') !!}</label>
					<div class="col-xs-4">
						{!! Form::text('subject',''
	        				, array(
								'placeHolder' => trans('messages.subject')
								, 'ng-model' => 'payment.invoice.subject_name'
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>

					<label class="col-xs-2 control-label">{!! trans('messages.payment_status') !!}</label>
					<div class="col-xs-4">
						{!! Form::text('name',''
	        				, array(
								'placeHolder' => trans('messages.payment_status')
								, 'ng-model' => 'payment.invoice.payment_status'
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">{!! trans('messages.subscription') !!}</label>
					<div class="col-xs-4">
						<select ng-model="payment.invoice.subscription_id" 
							ng-disabled="true" 
							ng-init="payment.listSubscription()"
							ng-change="payment.setSubscription()" class="form-control" name="subscription_id" ng-class="{ 'required-field' : payment.fields['subscription_id'] }">

							<option value="">{!! trans('messages.select_subscription') !!}</option>
							<option ng-selected="payment.invoice.subscription_id == subscription.id" ng-repeat="subscription in payment.subscriptions" ng-value="subscription.id">{! subscription.name !}</option>
						</select>
					</div>

					<label class="col-xs-1 control-label">{!! trans('messages.starting') !!}</label>
					<div class="col-xs-2">
						<input class="form-control" ng-disabled="true" value="{! payment.invoice.dis_date_start | ddMMyy !}" placeholder="DD/MM/YY" />
					</div>

					<label class="col-xs-1 control-label">{!! trans('messages.to') !!}</label>
					<div class="col-xs-2">
						<input class="form-control" ng-disabled="true" value="{! payment.invoice.dis_date_end | ddMMyy !}" placeholder="DD/MM/YY" />
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
									, 'placeholder' => trans('messages.discount')
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

		<div class="col-xs-12">
			<div class="invoice-group">
				<p>{!! trans('messages.no_signature_req') !!}<br/>
				{!! trans('messages.electronic_invoice') !!}</p>
			</div>

			<div class="invoice-group">
				<p>{!! trans('messages.payment_method') !!}:<br/>
				{!! trans('messages.direct_credit_to') !!}: {! futureed.CC_NAME !}<br/>
				{!! trans('messages.bank_name') !!}: {! futureed.BANK_NAME !}<br/>
				{!! trans('messages.bank_account_number') !!}: <br/>
				{! futureed.BANK_ACCT_NO_SGD !}<br/>
				{! futureed.BANK_ACCT_NO_USD !}<br/>
				{!! trans('messages.bank_address') !!}: {! futureed.BANK_ADDRESS !}<br/>
				{!! trans('messages.bank_code') !!}: {! futureed.BANK_CODE !}
				</p>
			</div>
		</div>
	</div>
	
	<div class="col-xs-12" ng-if="payment.invoice.payment_status">
		<div class="col-xs-12 margin-30-bot">
			<hr />

			<div class="btn-container" ng-if="payment.invoice.payment_status == futureed.PENDING">
	    		{!! Form::button(trans('messages.delete_subscription')
	    			, array(
	    				'class' => 'btn btn-gold btn-small pull-right'
	    				, 'ng-click' => 'payment.deleteInvoice(payment.invoice.id)'
	    			)
	    		) !!}

	    		{!! Form::button(trans('messages.save_subscription')
	    			, array(
	    				'class' => 'btn btn-blue btn-small pull-right'
	    				, 'ng-click' => 'payment.updateSubscription(futureed.TRUE)'
	    			)
	    		) !!}

	    		{!! Form::button(trans('messages.pay_subscription')
	    			, array(
	    				'class' => 'btn btn-blue btn-small pull-right'
	    				, 'ng-click' => 'payment.updateSubscription()'
	    			)
	    		) !!}
			</div>
			<div class="btn-container" 
				ng-if="payment.invoice.payment_status == futureed.PAID || payment.invoice.payment_status == futureed.CANCELLED">
				{!! Form::button(trans('messages.view_list')
	    			, array(
	    				'class' => 'btn btn-gold btn-small pull-right'
	    				, 'ng-click' => 'payment.setActive()'
	    			)
	    		) !!}

				{!! Form::button(trans('messages.renew_subscription')
	    			, array(
	    				'class' => 'btn btn-blue btn-small pull-right'
	    				, 'ng-disabled' => '!payment.invoice.expired'
	    				, 'ng-click' => 'payment.renewPayment()'
	    				, 'ng-if' => "payment.invoice.payment_status == futureed.PAID"
	    			)
	    		) !!}
			</div>
		</div>
	</div>
</div>