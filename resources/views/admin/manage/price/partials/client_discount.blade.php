<div ng-if="discount.active_list">
	<div class="col-xs-12 search-container" ng-if="discount.active_add">
		<div class="col-xs-12">
			<div class="title-mid">
				{!! trans('messages.admin_add_client_discount') !!}
			</div>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="discount.active_edit">
		<div class="col-xs-12">
			<div class="title-mid">
				{!! trans('messages.admin_update_client_discount') !!}
			</div>
		</div>
	</div>

	<div class="col-xs-12" ng-class="{ 'success-container' : discount.active_add || discount.active_edit, 'search-container' : !(discount.active_add || discount.active_edit) }" ng-if="discount.errors || discount.success">
		<div class="alert alert-error" ng-if="discount.errors">
			<p ng-repeat="error in discount.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="discount.success">
			<p>{! discount.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="discount.active_add || discount.active_edit">
		{!! Form::open(['class'=> 'form-horizontal']) !!}
			<fieldset>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.name') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('name', '', 
							[
								'class' => 'form-control'
								, 'ng-model' => 'discount.record.name'
								, 'placeholder' => trans('messages.name')
								, 'autocomplete' => 'off'
								, 'ng-disabled' => 'discount.active_edit'
								, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
								, 'ng-change' => 'discount.suggestClient()'
								, 'ng-class' => "{ 'required-field' : discount.fields['name'] || discount.fields['user_id'] }"
							])
						!!}
						<div class="angucomplete-holder" ng-if="discount.clients && discount.active_add">
							<ul class="col-xs-5 angucomplete-dropdown">
								<li class="angucomplete-row" ng-repeat="client in discount.clients" ng-click="discount.selectClient(client)">
									{! client.first_name !} {! client.last_name !}
								</li>
							</ul>
						</div>
					</div>
					<div class="margin-top-8" ng-if="discount.active_add"> 
						<i ng-if="discount.validation.c_loading" class="fa fa-spinner fa-spin"></i>
						<span ng-if="discount.validation.c_error" class="error-msg-con">{! discount.validation.c_error !}</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.email') !!}</label>
					<div class="col-xs-5">
						{!! Form::text('email', '', 
							[	
								'class' => 'form-control' 
								, 'ng-disabled' => 'true'
								, 'ng-model' => 'discount.record.email'
								, 'ng-class' => "{ 'required-field' : discount.fields['email'] }"
								, 'placeholder' => trans('messages.email_address')
							]) 
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.admin_percentage') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						<div class="input-group">
							{!! Form::text('percentage', '', 
								[	
									'class' => 'form-control' 
									, 'placeholder' => trans('messages.admin_discount_percentage')
									, 'ng-model' => 'discount.record.percentage'
									, 'ng-class' => "{ 'required-field' : discount.fields['percentage'] }"
								]) 
							!!}
							<span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.status') !!} <span class="required">*</span></label>
					<div class="col-xs-6">
						<div class="col-xs-6 checkbox">	                				
							<label>
							{!! Form::radio('example','Enabled', true, 
								[
									'class' => 'field', 
									'ng-model'=> 'discount.record.status'
								]) 
							!!}
							<span class="lbl padding-8">{!! trans('messages.enabled') !!}</span>
							</label>
						</div>
						<div class="col-xs-6 checkbox">
							<label>
							{!! Form::radio('example', 'Disabled', false, 
								[
									'class' => 'field', 
									'ng-model'=> 'discount.record.status'
								]) 
							!!}
							<span class="lbl padding-8">{!! trans('messages.disabled') !!}</span>
							</label>
						</div>
					</div>
				</div>
				</fieldset>
				<fieldset>
					<div class="form-group">
						<div class="btn-container col-xs-9 col-xs-offset-1">
							{!! Form::button(trans('messages.update')
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => "discount.update()"
									, 'ng-if' => 'discount.active_edit'
								)
							) !!}

							{!! Form::button(trans('messages.admin_add_client_discount')
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => "discount.add()"
									, 'ng-if' => 'discount.active_add'
								)
							) !!}

							{!! Form::button(trans('messages.cancel')
								, array(
									'class' => 'btn btn-gold btn-medium'
									, 'ng-click' => "discount.setActive()"
								)
							) !!}
						</div>
					</div>
				</fieldset>
			{!! Form::close() !!}
		</div>

		<div class="col-xs-12 search-container">
			<button class="btn btn-blue btn-semi-medium" 
				ng-click="discount.setActive(futureed.ACTIVE_ADD)"
				ng-if="!(discount.active_add || discount.active_edit)">
				<span><i class="fa fa-plus-square"></i></span> {!! trans('messages.admin_add_client_discount') !!}
			</button>

			<div class="list-container" ng-cloak>
				<div class="col-xs-6 title-mid">
					{!! trans('messages.admin_client_discount_list') !!}
				</div>

				<div class="col-xs-6 size-container">
					{!! Form::select('size'
						, array(
							  '10' => '10'
							, '20' => '20'
							, '50' => '50'
							, '100' => '100'
						)
						, '10'
						, array(
							'ng-model' => 'discount.table.size'
							, 'ng-change' => 'discount.paginateBySize()'
							, 'ng-if' => "discount.records.length"
							, 'class' => 'form-control paginate-size pull-right'
						)
					) !!}
				</div>

				<table class="col-xs-12 table table-striped table-bordered">
					<thead>
						<tr>
							<th>{!! trans('messages.name') !!}</th>
							<th>{!! trans('messages.email') !!}</th>
							<th>{!! trans('messages.user') !!}</th>
							<th>{!! trans('messages.discount') !!}</th>
							<th ng-if="discount.records.length">{!! trans_choice('messages.action', 1) !!}</th>
						</tr>
						</thead>
					<tbody>
						<tr ng-repeat="record in discount.records">
							<td>{! record.user.name !}</td>
							<td>{! record.user.email !}</td>
							<td>{! record.user.user_type !}</td>
							<td>{! record.percentage | percent !}</td>
							<td>
								<div class="row">
									<div class="col-xs-4">
										<i class="fa" 
											ng-class="{ 'fa-ban error-icon' : record.status == futureed.DISABLED, 'fa-check-circle-o success-icon' : record.status == futureed.ENABLED }"
											tooltip="{! record.status !}"
											tooltip-placement="top"
											tooltip-trigger="mouseenter"></i>
									</div>
									<div class="col-xs-4">
										<a href="" ng-click="discount.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
									</div>
									<div class="col-xs-4">
										<a href="" ng-click="discount.deleteClientDiscount(record.id)"><span><i class="fa fa-trash"></i></span></a>
									</div>
								</div>
							</td>
						</tr>
						<tr class="odd" ng-if="!discount.records.length">
							<td valign="top" colspan="5">
								{!! trans('messages.no_records_found') !!}
							</td>
						</tr>
					</tbody>
				</table>
				<div class="pull-right" ng-if="discount.records.length">
					<pagination 
						total-items="discount.table.total_items" 
						ng-model="discount.table.page"
						max-size="3"
						items-per-page="discount.table.size" 
						previous-text = "&lt;"
						next-text="&gt;"
						class="pagination" 
						boundary-links="true"
						ng-change="discount.paginateByPage()">
					</pagination>
				</div>
			</div>
		</div>
	</div>	