<div ng-if="payment.active_view || payment.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Sales Invoice</span>
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
	                            <option value="">-- Select Level --</option>
	                            <option ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
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

		        		{!! Form::button('Add'
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
	</div>

	<div class="col-xs-7 search-container">
		<div class="form-search" ng-init="payment.getSchoolCode()">
			{!! Form::open(
					[
						'id' => 'search_form',
						'class' => 'form-horizontal'
					]
			) !!}
			<div class="form-group">
				<label class="col-xs-12">
					<p class="title-main-content">{! payment.school.school_name !}</p>
				</label>
			</div>
			<div class="form-group">
				<label class="col-xs-4 control-label">Contact name : </label>
				<p class="col-xs-8 control-label pull-left">
					{! payment.school.school_contact_name !}
				</p>
			</div>
			<div class="form-group">
				<label class="col-xs-4 control-label">Contact Number : </label>
				<p class="col-xs-8 control-label pull-left">
					{! payment.school.school_contact_number !}
				</p>
			</div>
			<div class="form-group">
				<label class="col-xs-4 control-label">School Address : </label>
				<p class="col-xs-8 control-label pull-left">
					{! payment.school.school_street_address !}
				</p>
			</div>
			{!! Form::close() !!}
		</div>
	</div>

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
				<label class="col-xs-2 control-label">Payment Status</label>
				<div class="col-xs-4">
					{!! Form::text('name',''
        				, array(
        					'placeHolder' => 'Payment Status'
        					, 'ng-model' => 'payment.invoice.payment_status'
        					, 'ng-disabled' => 'true'
        					, 'class' => 'form-control'
        				)
        			) !!}
				</div>
				<div class="col-xs-6"></div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Subscription</label>
				<div class="col-xs-4">
					<select ng-model="payment.invoice.subscription_id" 
						ng-disabled="!payment.subscriptions.length || payment.invoice.payment_status !== futureed.PENDING" 
						ng-init="payment.listSubscription()"
						ng-change="payment.selectSubscription()" class="form-control">

						<option value="">-- Select Subscription --</option>
						<option ng-selected="payment.invoice.subscription_id == subscription.id" ng-repeat="subscription in payment.subscriptions" ng-value="subscription.id">{! subscription.name !}</option>
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
			            <th ng-if="payment.invoice.payment_status == futureed.PENDING">Action</th>
			        </tr>
			    </thead>

		        <tbody>
		        <tr ng-repeat="room in payment.classrooms">
		            <td>{! room.seats_total !}</td>
		            <td>{! room.grade.name !}</td>
		            <td>{! room.client.first_name !} {! room.client.last_name !}</td>
		            <td>{! room.name !}</td>
		            <td>{! room.price | currency : "USD$ " : 2 !}</td>
		            <td ng-if="payment.invoice.payment_status == futureed.PENDING">
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
		<div class="margin-30-bot">
			<div class="row margin-10-bot">
				<div class="col-xs-4 div-right">
					<label class="col-xs-4 control-label top-10">Sub Total</label>
					<div class="col-xs-8">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">USD$</span>
							{!! Form::text('sub_total',''
								, [
									'ng-disabled' => true
									, 'class' => 'form-control'
									, 'ng-model' => 'payment.invoice.sub_total'

								]
							) !!}
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
							  {!! Form::text('total_amount',''
								, [
									'ng-disabled' => true
									, 'class' => 'form-control'
									, 'ng-model' => 'payment.invoice.total_amount'

								]
							) !!}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 margin-30-bot">
			<div class="btn-container" ng-if="payment.invoice.payment_status == futureed.PENDING">
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
			<div class="btn-container" ng-if="payment.invoice.payment_status !== futureed.PENDING">
				{!! Form::button('View List'
        			, array(
        				'class' => 'btn btn-gold btn-small div-right'
        				, 'ng-click' => 'payment.setActive()'
        			)
        		) !!}

				{!! Form::button('Renew Subscription'
        			, array(
        				'class' => 'btn btn-blue btn-small div-right'
        				, 'ng-disabled' => 'true'
        				, 'ng-click' => 'payment.addPayment()'
        				, 'ng-if' => "payment.invoice.payment_status == 'Paid'"
        			)
        		) !!}
			</div>
		</div>
	</div>
</div>