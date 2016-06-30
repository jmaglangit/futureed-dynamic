<div ng-if="invoice.active_view || invoice.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_view_invoice') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="invoice.errors || invoice.success">
		<div class="alert alert-error" ng-if="invoice.errors">
			<p ng-repeat="error in invoice.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="invoice.success">
            <p>{! invoice.success !}</p>
        </div>
    </div>

	<div class="col-xs-12 search-container">
		<div class="form-search">
			{!! Form::open(
					array(
						'id' => 'search_form',
						'class' => 'form-horizontal'
					)
			) !!}
				<div class="form-group">
					<label class="col-xs-2 control-label">{!! trans('messages.subject') !!}</label>
					<div class="col-xs-4">
						{!! Form::text('subject', ''
							, array(
								  'ng-disabled' => 'true'
								, 'class' => 'form-control'
								, 'ng-model' => 'invoice.record.invoice_detail[0].classroom.subject.name'
								, 'placeholder' => trans('messages.subject')
							)
						) !!}
					</div>
					<label class="col-xs-2 control-label">{!! trans('messages.payment_status') !!}</label>
					<div class="col-xs-4">
						{!! Form::select('search_status'
							, array(
								  ''=>trans('messages.admin_select_status')
								, 'Pending' => trans('messages.pending')
								, 'Paid' => trans('messages.paid')
							 	, 'Cancelled' => trans('messages.cancelled')
						 	)
						 	, null
						 	, array(
						 		'ng-disabled' => 'invoice.active_view'
						 		, 'class' => 'form-control'
						 		, 'ng-model' => 'invoice.record.payment_status'
						 		, 'ng-class' => "{ 'required-field' : invoice.fields['payment_status'] }"
						 		, 'placeholder' => trans('messages.email')
						 	)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Invoice No.</label>
					<div class="col-xs-4">
						{!! Form::text('invoice_no', ''
							, array(
								  'ng-disabled' => 'true'
								, 'class' => 'form-control'
								, 'ng-model' => 'invoice.record.id'
								, 'placeholder' => trans('messages.admin_invoice_no')
							)
						) !!}
					</div>
					<label class="col-xs-2 control-label">{!! trans('messages.payment_status') !!}</label>
					<div class="col-xs-4">
						{!! Form::text('subscription_name', ''
							, array(
								  'ng-disabled' => 'true'
								, 'class' => 'form-control'
								, 'ng-model' => 'invoice.record.subscription.name'
								, 'placeholder' => trans('messages.subscription')
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">{!! trans('messages.date_started') !!}</label>
					<div class="col-xs-4">
						<input type="text" ng-disabled="true" class="form-control" value="{! invoice.record.date_start | ddMMyy !}"/>
					</div>
					<label class="col-xs-2 control-label">{!! trans('messages.date_end') !!}</label>
					<div class="col-xs-4">
						<input type="text" ng-disabled="true" class="form-control" value="{! invoice.record.date_end | ddMMyy !}"/>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="list-container" ng-cloak>
			<div class="title-mid">
				{!! trans('messages.admin_order_list') !!}
			</div>

			<table id="class-list" class="table table-striped table-bordered" ng-if="!invoice.view_students_tables">
				<thead>
					<tr>
						<td>{!! trans_choice('messages.no_of_seats', 1) !!}</td>
						<td>{!! trans('messages.seats_taken') !!}</td>
						<td>{!! trans_choice('messages.grade', 1) !!}</td>
						<td>{!! trans('messages.teacher') !!}</td>
						<td>{!! trans('messages.class') !!}</td>
						<td>{!! trans('messages.price') !!}</td>
					</tr>
				</thead>
	        	<tbody>
					<tr ng-repeat="detail in invoice.record.invoice_detail">
						<td>{! detail.classroom.seats_total !}</td>
						<td>{! detail.classroom.seats_taken !}</td>
						<td>{! detail.grade.name !}</td>
						<td>{! detail.classroom.client.first_name !} {! detail.classroom.client.last_name !}</td>
						<td>{! detail.classroom.name !}</td>
						<td>{! detail.price | currency : "USD$ " : 2 !}</td>
					</tr>
					<tr class="odd" ng-if="!invoice.record.invoice_detail.length">
						<td valign="top" colspan="6" >
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
				</tbody>
			</table>
			<table id="class-list" class="table table-striped table-bordered" ng-if="invoice.view_students_tables">
				<thead>
					<tr>
						<td>{!! trans('messages.name') !!}</td>
						<td>{!! trans('messages.email') !!}</td>
						<td>{!! trans('messages.date_added') !!}</td>
						<td>{!! trans('messages.date_removed') !!}</td>
					</tr>
				</thead>
	        	<tbody>
					<tr ng-repeat="student in invoice.students">
						<td>{! student.student.user.name !}</td>
						<td>{! student.student.user.email !}</td>
						<td>{! student.date_started | ddMMyy !}</td>
						<td>{! student.date_removed | ddMMyy !}</td>
					</tr>
					<tr class="odd" ng-if="!invoice.students.length">
						<td valign="top" colspan="6" >
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<a href="" class="pull-right" ng-if="invoice.view_student_list_link" ng-click="invoice.viewAllStudents(invoice.record.id)">{!! trans('messages.admin_view_all_student_under_this_order') !!}</a>
		<a href="" class="pull-right" ng-if="!invoice.view_student_list_link" ng-click="invoice.details(invoice.record.id, 'view')">{!! trans('messages.admin_back_to_class_list') !!}</a>
	</div>

	<div class="col-xs-12 search-container">
		<div class="">
			{!! Form::open(
					array(
						'id' => 'search_form',
						'class' => 'form-horizontal'
					)
			) !!}
				<div class="form-group">
					<div class="col-xs-6"></div>
					<label class="col-xs-2 control-label">{!! trans('messages.subtotal') !!}</label>
					<div class="col-xs-4">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">{!! trans('messages.usd') !!}</span>
							<input type="text" ng-disabled="true" class="form-control" value="{! invoice.record.subtotal | currency : '' : 2 !}" placeholder="Sub Total" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-6"></div>
					<label class="col-xs-2 control-label">{!! trans('messages.discount') !!}</label>
					<div class="col-xs-4">
						<div class="input-group">
							{!! Form::text('discount',''
								, [
									'ng-disabled' => true
									, 'class' => 'form-control'
									, 'ng-model' => 'invoice.record.discount'
									, 'placeholder' => trans('messages.discount')
								]
							) !!}
							<span class="input-group-addon" id="basic-addon1">%</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-6"></div>
					<label class="col-xs-2 control-label">{!! trans('messages.total') !!}</label>
					<div class="col-xs-4">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">{!! trans('messages.usd') !!}</span>
							<input type="text" ng-disabled="true" class="form-control" value="{! invoice.record.total | currency : '' : 2 !}" placeholder="Total" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-6"></div>
					<div class="col-xs-6 btn-container" ng-if="invoice.active_view">
						{!! Form::button(trans('messages.edit_status')
		        			, array(
		        				'class' => 'btn btn-blue btn-medium'
		        				, 'ng-click' => "invoice.setActive('edit')"
		        				, 'ng-if' => 'invoice.active_view'
		        			)
		        		) !!}

		        		{!! Form::button(trans('messages.cancel')
		        			, array(
		        				'class' => 'btn btn-gold btn-medium'
		        				, 'ng-click' => "invoice.setActive()"
		        			)
		        		) !!}
					</div>

					<div class="col-xs-6 btn-container" ng-if="invoice.active_edit">

		        		{!! Form::button(trans('messages.save_status')
		        			, array(
		        				'class' => 'btn btn-blue btn-medium'
		        				, 'ng-click' => "invoice.updateStatus()"
		        				, 'ng-if' => 'invoice.active_edit'
		        			)
		        		) !!}

		        		{!! Form::button(trans('messages.cancel')
		        			, array(
		        				'class' => 'btn btn-gold btn-medium'
		        				, 'ng-click' => "invoice.details(invoice.record.id, 'view')"
		        			)
		        		) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>