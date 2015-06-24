<div ng-if="payment.active_view">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Payment</span>
		</div>
	</div>
	<div class="container form-content">
		<div class="col-xs-12">
			<div class="col-xs-3 pull-right">
				{!! Form::button('Print'
					, array(
						'class' => 'btn btn-blue btn-medium pull-right'
						, 'ng-click' => 'student.addStudent()'
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
						<select ng-disabled="true" name="subscription" 
								id="subscription" 
								class="form-control">
	                        <option value="">-- Select Subscription --</option>
	                        <option ng-repeat="subscription in payment.subscriptions">{! subscription.name!}</option>
	                    </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Date Started</label>
					<div class="col-xs-4">
						<input name="date_start" class="form-control" ng-disabled="true" value="{! payment.invoice.date_start | ddMMyyyy !}" placeholder="DD/MM/YYYY" />
					</div>
					<label class="control-label col-xs-2">Date End</label>
					<div class="col-xs-4">
						<input name="date_end" class="form-control" ng-disabled="true" value="{! payment.invoice.date_end | ddMMyyyy !}" placeholder="DD/MM/YYYY" />
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
			            <td>{! key.student_user.name !}</td>
			            <td>{! key.student_user.email !}</td>
			            <td>{! payment.students.price !}</td>
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
						{!! Form::text('subtotal',''
	        				, array(
	        					'placeHolder' => 'subtotal'
	        					, 'ng-model' => 'payment.invoice.subtotal'
	        					, 'class' => 'form-control'
	        					, 'ng-disabled' => 'true'
	        				)
	        			) !!}
					</div>	
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">Discount</label>
					<div class="col-xs-8">
						{!! Form::text('discount',''
	        				, array(
	        					'placeHolder' => 'subtotal'
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
						<input type="text" placeHolder="Subtotal" class="form-control" ng-disabled="true" value="{! payment.invoice.total | number:2 !}">
					</div>	
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="btn-container margin-30-top">
				{!! Form::button('Renew Subscription'
					, array(
						'class' => 'btn btn-blue btn-semi-large'
						, 'ng-click' => 'payment.renew()'
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