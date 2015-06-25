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
			<div class="col-xs-3 pull-right">
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
								ng-change="payment.setDate()"
								ng-model="payment.no_days"
								id="subscription" 
								class="form-control">
	                        <option value="">-- Select Subscription --</option>
	                        <option ng-repeat="subscription in payment.subscriptions" ng-selected="payment.invoice.subscription.name == subscription.name" data-id="{! subscription.price !}" value="{! subscription.days !}">{! subscription.name!}</option>
	                    </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Date Started</label>
					<div class="col-xs-4">
						{!! Form::text('start_date', '',
							['class' => 'form-control'
								, 'ng-model' => 'payment.date.start_date'
								, 'placeholder' => 'Start Date'
								, 'ng-disabled' => 'true'
							]) 
						!!}
					</div>
					<label class="control-label col-xs-2">Date End</label>
					<div class="col-xs-4">
						{!! Form::text('end_date', '',
							['class' => 'form-control'
								, 'ng-model' => 'payment.date.end_date'
								, 'placeholder' => 'End Date'
								, 'ng-disabled' => 'true'
							]) 
						!!}
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
			            <td>{! payment.students.price | number: 2 !}</td>
			            <td>
			            	<div class="row">
			            		<div>
		    						<a href="" ng-click="payment.setActive('view', key.id)"><span><i class="fa fa-trash"></i></span></a>
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
						<input type="text" class="form-control" placeHolder="Subtotal" value="{! payment.payment_total.subtotal | number:2 !}" ng-disabled="true">
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
						<input type="text" class="form-control" placeHolder="Total" value="{! payment.payment_total.total | number:2 !}" ng-disabled="true">
					</div>	
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="btn-container margin-30-top">
				{!! Form::button('Pay Subscription'
					, array(
						'class' => 'btn btn-blue btn-semi-large'
						, 'ng-click' => 'payment.renew()'
						, 'ng-if' => "payment.invoice.payment_status == 'Pending'"
					)
				) !!}
				{!! Form::button('Renew Subscription'
					, array(
						'class' => 'btn btn-blue btn-semi-large'
						, 'ng-click' => 'payment.renew()'
						, 'ng-if' => "payment.invoice.payment_status == 'Paid'"
						, 'ng-disabled' => 'true'
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "payment.setActive('list')"
					)
				) !!}
			</div>
		</div>
	</div>
</div>