<div ng-if="payment.active_add" ng-init="payment.getOrderNo()">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Payment</span>
		</div>
	</div>

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
	        <fieldset>
	        	<div class="form-group">
	        		<label class="col-xs-4 control-label" id="email">Number of Seats <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('seats_total',''
	        				, array(
	        					'placeHolder' => 'Number of Seats'
	        					, 'ng-model' => 'payment.classroom.seats_total'
	        					, 'ng-class' => "{ 'required-field' : payment.fields['seats_total'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group" ng-init="getGradeLevel(user.country_id)">
	        		<label class="col-xs-4 control-label">Grade <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			<select name="grade_id" ng-class="{ 'required-field' : payment.fields['grade_id'] }" class="form-control" ng-model="payment.classroom.grade_id">
                            <option ng-selected="payment.classroom.grade_id == futureed.false" value="">-- Select Level --</option>
                            <option ng-selected="payment.classroom.grade_id == grade.id" ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
                        </select>
	        		</div>		
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-4 control-label" id="email">Teacher <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('teacher',''
	        				, array(
	        					'placeHolder' => 'Teacher'
	        					, 'ng-model' => 'payment.classroom.client_name'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-class' => "{ 'required-field' : payment.fields['client_id'] }"
	        					, 'ng-change' => "payment.suggestTeacher()"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}

	        			<div class="angucomplete-holder" ng-if="payment.teachers.length">
							<ul class="col-xs-5 angucomplete-dropdown">
								<li class="angucomplete-row" ng-repeat="teacher in payment.teachers" ng-click="payment.selectTeacher(teacher)">
									{! teacher.first_name !} {! teacher.last_name !}
								</li>
							</ul>
						</div>
	        		</div>

	        		<div class="margin-top-8" ng-if="payment.validation.c_loading || payment.validation.c_error"> 
		                <i ng-if="payment.validation.c_loading" class="fa fa-spinner fa-spin"></i>
		                <span ng-if="payment.validation.c_error" class="error-msg-con">{! payment.validation.c_error !}</span>
		            </div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-4 control-label">Class <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('name',''
	        				, array(
	        					'placeHolder' => 'Class'
	        					, 'ng-model' => 'payment.classroom.name'
	        					, 'ng-class' => "{ 'required-field' : payment.fields['name'] }"
	        					, 'autocomplete' => 'off'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="btn-container col-xs-offset-2 col-xs-7">
	        		{!! Form::button('Update'
	        			, array(
	        				'class' => 'btn btn-blue btn-medium'
	        				, 'ng-click' => 'payment.updateClassroom()'
	        				, 'ng-if' => 'payment.classroom.update'
	        			)
	        		) !!}

	        		{!! Form::button('Add Classroom'
	        			, array(
	        				'class' => 'btn btn-blue btn-medium'
	        				, 'ng-click' => 'payment.addClassroom()'
	        				, 'ng-if' => '!payment.classroom.update'
	        			)
	        		) !!}

	        		{!! Form::button('Clear'
	        			, array(
	        				'class' => 'btn btn-gold btn-medium'
	        				, 'ng-click' => 'payment.clearClassroom()'
	        			)
	        		) !!}
	        	</div>
	        </fieldset>
		</div>
	{!! Form::close() !!}

	<div class="col-xs-12 search-container">
		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'search_form',
						'class' => 'form-horizontal'
						, 'ng-submit' => 'payment.searchFnc($event)'
					]
			) !!}
			<div class="form-group">
				<label class="col-xs-2 control-label">Subscription</label>
				<div class="col-xs-4">
					<select ng-model="payment.invoice.subscription_id" 
						ng-disabled="!payment.subscriptions.length" 
						ng-init="payment.listSubscription()"
						ng-change="payment.selectSubscription()" class="form-control">

						<option value="">-- Select Subscription --</option>
						<option ng-repeat="subscription in payment.subscriptions" ng-value="subscription.id">{! subscription.name !}</option>
					</select>
				</div>
				<div class="col-xs-6">
					<label class="col-xs-2 control-label">Starting</label>
					<div class="col-xs-4">
						<input class="form-control" ng-disabled="true" value="{! payment.invoice.dis_date_start | ddMMyy !}" placeholder="DD/MM/YY" />
					</div>
					<label class="col-xs-2 control-label">To</label>
					<div class="col-xs-4">
						<input class="form-control" ng-disabled="true" value="{! payment.invoice.dis_date_end | ddMMyy !}" placeholder="DD/MM/YY" />
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 table-container">
		<div class="list-container" ng-cloak>
			<table class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Number of Seats</th>
			            <th>Grade</th>
			            <th>Teacher</th>
			            <th>Class</th>
			            <th>Price</th>
			            <th>Action</th>
			        </tr>
			    </thead>

		        <tbody>
		        <tr ng-repeat="room in payment.classrooms">
		            <td>{! room.seats_total !}</td>
		            <td>{! room.grade.name !}</td>
		            <td>{! room.client.first_name !} {! room.client.last_name !}</td>
		            <td>{! room.name !}</td>
		            <td>{! room.price | currency : "USD$ " : 2 !}</td>
		            <td>
		            	<div class="row">
		            		<div class="col-xs-6">
	    						<a href="" ng-click="payment.getClassroom(room.id)"><span><i class="fa fa-pencil"></i></span></a>
	    					</div>
		            		<div class="col-xs-6">
	    						<a href="" ng-click="payment.removeClassroom(room.id)"><span><i class="fa fa-trash"></i></span></a>
	    					</div>
		            	</div>
		            </td>
		        </tr>
		        <tr class="odd" ng-if="!payment.classrooms.length && !payment.table.loading">
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

	<div class="col-xs-12">
		<div class="row margin-10-bot">
			<div class="col-xs-4 div-right">
				<label class="col-xs-4 control-label top-10">Sub Total</label>
				<div class="col-xs-8">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">USD$</span>
						<input type="text" ng-disabled="true" class="form-control" value="{! payment.invoice.sub_total | currency : '' : 2 !}" placeholder="Sub Total" />
					</div>
				</div>
			</div>
		</div>
		<div class="row margin-10-bot">
			<div class="col-xs-4 div-right">
				<label class="col-xs-4 control-label top-10">Discount</label>
				<div class="col-xs-8">
					<div class="input-group">
						{!! Form::text('discount',''
							, [
								'ng-disabled' => true
								, 'class' => 'form-control'
								, 'ng-model' => 'payment.invoice.discount'

							]
						) !!}
						<span class="input-group-addon" id="basic-addon1">%</span>
					</div>
				</div>
			</div>
		</div>

		<div class="row margin-10-bot">
			<div class="col-xs-4 div-right">
				<label class="col-xs-4 control-label top-10">Total</label>
				<div class="col-xs-8">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">USD$</span>
						<input type="text" ng-disabled="true" class="form-control" value="{! payment.invoice.total_amount | currency : '' : 2 !}" placeholder="Total" />
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 margin-30-bot">
			<div class="btn-container">
				{!! Form::button('Delete Subscription'
        			, array(
        				'class' => 'btn btn-gold btn-small div-right'
        				, 'ng-click' => 'payment.deleteInvoice(payment.invoice.id)'
        			)
        		) !!}

        		{!! Form::button('Save Subscription'
        			, array(
        				'class' => 'btn btn-blue btn-small div-right'
        				, 'ng-click' => 'payment.savePayment()'
        			)
        		) !!}

        		{!! Form::button('Pay Subscription'
        			, array(
        				'class' => 'btn btn-blue btn-small div-right'
        				, 'ng-click' => 'payment.addPayment()'
        			)
        		) !!}        		
			</div>
		</div>
	</div>
</div>