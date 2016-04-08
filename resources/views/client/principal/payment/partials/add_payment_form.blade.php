<div ng-if="payment.active_add" ng-init="payment.getOrderNo()">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.add_payment') !!}</span>
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

        	<fieldset class="payment-field">
        		<span class="step">1</span><p class="step-label">{!! trans('messages.please_select_subject') !!}</p>

        		<div class="col-xs-12">
	        		<div class="form-search">
			        	<div class="form-group">
			        		<label class="col-xs-3 control-label">{!! trans('messages.subject') !!} <span class="required">*</span></label>
			        		<div class="col-xs-5">
			        			<select class="form-control" ng-disabled="!payment.subjects.length" ng-model="payment.invoice.subject_id" ng-class="{ 'required-field' : payment.fields['subject_id'] }">
				                        <option value="">{!! trans('messages.select_subject') !!}</option>
				                        <option ng-selected="payment.invoice.subject_id == subject.id" ng-repeat="subject in payment.subjects" ng-value="subject.id">{! subject.name !}</option>
				                    </select>
			        		</div>
			        	</div>
			        </div>
			    </div>
	        </fieldset>

		    <hr />

        	<fieldset class="payment-field">
	        	<span class="step">2</span><p class="step-label">{!! trans('messages.please_add_classroom') !!}</p>

	        	<div class="col-xs-12">
		        	<div class="form-search">
			        	<div class="form-group">
			        		<label class="col-xs-3 control-label" id="email">{!! trans('messages.no_of_seats') !!} <span class="required">*</span></label>
			        		<div class="col-xs-5">
			        			{!! Form::text('seats_total',''
			        				, array(
			        					'placeHolder' => trans('messages.no_of_seats')
			        					, 'ng-model' => 'payment.classroom.seats_total'
			        					, 'ng-class' => "{ 'required-field' : payment.fields['seats_total'] }"
			        					, 'class' => 'form-control'
			        				)
			        			) !!}
			        		</div>
			        	</div>

			        	<div class="form-group" ng-init="getGradeLevel(user.country_id)">
			        		<label class="col-xs-3 control-label">{!! trans('messages.grade') !!} <span class="required">*</span></label>
			        		<div class="col-xs-5">
			        			<select name="grade_id" ng-disabled="!grades.length" ng-class="{ 'required-field' : payment.fields['grade_id'] }" class="form-control" ng-model="payment.classroom.grade_id">
		                            <option ng-selected="payment.classroom.grade_id == futureed.false" value="">{!! trans('messages.select_level') !!}</option>
		                            <option ng-selected="payment.classroom.grade_id == grade.id" ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
		                        </select>
			        		</div>		
			        	</div>

			        	<div class="form-group">
			        		<label class="col-xs-3 control-label" id="email">{!! trans('messages.teacher') !!} <span class="required">*</span></label>
			        		<div class="col-xs-5">
			        			{!! Form::text('teacher',''
			        				, array(
			        					'placeHolder' => trans('messages.teacher')
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
			        		<label class="col-xs-3 control-label">{!! trans('messages.class') !!} <span class="required">*</span></label>
			        		<div class="col-xs-5">
			        			{!! Form::text('name',''
			        				, array(
			        					'placeHolder' => trans('messages.class')
			        					, 'ng-model' => 'payment.classroom.name'
			        					, 'ng-class' => "{ 'required-field' : payment.fields['name'] }"
			        					, 'autocomplete' => 'off'
			        					, 'class' => 'form-control'
			        				)
			        			) !!}
			        		</div>
			        	</div>

			        	<div class="form-group">
			        		<div class="btn-container col-xs-offset-2 col-xs-7">
				        		{!! Form::button(trans('messages.update')
				        			, array(
				        				'class' => 'btn btn-blue btn-medium'
				        				, 'ng-click' => 'payment.updateClassroom()'
				        				, 'ng-if' => 'payment.classroom.update'
				        			)
				        		) !!}

				        		{!! Form::button(trans('messages.add_classroom')
				        			, array(
				        				'class' => 'btn btn-blue btn-medium'
				        				, 'ng-click' => 'payment.addClassroom()'
				        				, 'ng-if' => '!payment.classroom.update'
				        			)
				        		) !!}

				        		{!! Form::button(trans('messages.clear')
				        			, array(
				        				'class' => 'btn btn-gold btn-medium'
				        				, 'ng-click' => 'payment.clearClassroom()'
				        			)
				        		) !!}
				        	</div>
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
								<select ng-model="payment.invoice.subscription_id" 
									ng-disabled="!payment.subscriptions.length" 
									ng-init="payment.listSubscription()"
									ng-change="payment.selectSubscription()" 
									class="form-control" ng-class="{ 'required-field' : payment.fields['subscription_id'] }">

									<option value="">{!! trans('messages.select_subscription') !!}</option>
									<option ng-repeat="subscription in payment.subscriptions" ng-value="subscription.id">{! subscription.name !}</option>
								</select>
							</div>
							<div class="col-xs-8">
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
	        </fieldset>

	        <fieldset class="payment-field">
	        	<div class="col-xs-12">
					<div class="list-container" ng-cloak>
						<table class="table table-striped table-bordered">
							<thead>
						        <tr>
						            <th>{!! trans('messages.no_of_seats') !!}</th>
						            <th>{!! trans('messages.grade') !!}</th>
						            <th>{!! trans('messages.teacher') !!}</th>
						            <th>{!! trans('messages.class') !!}</th>
						            <th>{!! trans('messages.price') !!}</th>
						            <th>{!! trans('messages.action') !!}</th>
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
					        	<td valign="top" colspan="7">
					        		{!! trans('messages.no_records_found') !!}
					        	</td>
					        </tr>
					        <tr class="odd" ng-if="payment.table.loading">
					        	<td valign="top" colspan="7">
					        		{!! trans('messages.loading') !!}
					        	</td>
					        </tr>
					        </tbody>
						</table>
					</div>
				</div>
	        </fieldset>

	        <fieldset class="payment-field">
				<div class="form-group">
					<div class="col-xs-6"></div>
					<div class="col-xs-6 div-right">
						<label class="col-xs-4 control-label">{!! trans('messages.subtotal') !!}</label>
						<div class="col-xs-8">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">USD$</span>
								<input type="text" ng-disabled="true" class="form-control" value="{! payment.invoice.sub_total | currency : '' : 2 !}" placeholder="Subtotal" />
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-6"></div>
					<div class="col-xs-6 div-right">
						<label class="col-xs-4 control-label">{!! trans('messages.discount') !!}</label>
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

				<div class="form-group">
					<div class="col-xs-6"></div>
					<div class="col-xs-6 div-right">
						<label class="col-xs-4 control-label">{!! trans('messages.total') !!}</label>
						<div class="col-xs-8">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">USD$</span>
								<input type="text" ng-disabled="true" class="form-control" value="{! payment.invoice.total_amount | currency : '' : 2 !}" placeholder="Total" />
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="btn-container">
		        		{!! Form::button(trans('messages.pay_subscription')
		        			, array(
		        				'class' => 'btn btn-blue btn-semi-medium'
		        				, 'ng-click' => 'payment.addPayment()'
		        			)
		        		) !!}

		        		{!! Form::button(trans('messages.save_subscription')
		        			, array(
		        				'class' => 'btn btn-blue btn-semi-medium'
		        				, 'ng-click' => 'payment.savePayment()'
		        			)
		        		) !!}

		        		{!! Form::button(trans('messages.delete_subscription')
		        			, array(
		        				'class' => 'btn btn-gold btn-semi-medium'
		        				, 'ng-click' => 'payment.deleteInvoice(payment.invoice.id)'
		        			)
		        		) !!}
					</div>
				</div>

				<div class="form-group"></div>
	        </fieldset>
		</div>
	{!! Form::close() !!}
</div>