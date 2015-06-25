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
	</div>
	{!! Form::close() !!}
	<div class="col-xs-12">
		<div class="table-form">
			<div class="form-group">
				<div class="col-xs-3">
					<div class="col-xs-6">
						<b>Item</b>
					</div>
					<div class="col-xs-6">
						Subscription
					</div>	
				</div>
				<div class="col-xs-3">
					<select name="subscription" ng-disabled="!payment.subscriptions.length"
							id="subscription" 
							class="form-control"
							ng-change="payment.setDate()"
							ng-model="payment.no_days">
                        <option value="">-- Select Subscription --</option>
                        <option ng-repeat="subscription in payment.subscriptions" data-id="{! subscription.price !}" value="{! subscription.days !}">{! subscription.name!}</option>
                    </select>
				</div>
				<div class="col-xs-6">
					<label class="col-xs-2 control-label">Starting</label>
					<div class="col-xs-4">
						{!! Form::text('start_date', '',
							['class' => 'form-control'
								, 'ng-model' => 'payment.date.start_date'
								, 'placeholder' => 'Start Date'
								, 'ng-disabled' => 'true'
							]) 
						!!}
					</div>
					<label class="col-xs-2 control-label">To</label>
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
			</div>
			<div class="form-group margin-top-60">
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
							<td>{! payment.students.price | number: 2 !}</td>
							<td>
								<a href="#">Remove</a>
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
			<div class="row margin-10-bot">
				<div class="col-xs-4 div-right">
					<label class="col-xs-4 control-label">Sub Total</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" placeHolder="Subtotal" value="{! payment.payment_total.subtotal | number:2 !}" ng-disabled="true">
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
						<input type="text" class="form-control" placeHolder="Total" value="{! payment.payment_total.total | number:2 !}" ng-disabled="true">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 margin-30-bot">
		<div class="col-xs-5 div-right">
			<div class="btn-container">
				<button class="btn btn-blue btn-semi-large">Pay Subscription</button>
				<button class="btn btn-gold btn-medium" ng-click="payment.setActive('list')">Cancel</button>
			</div>
		</div>
	</div>
</div>