<div ng-if="price.active_list">
	<div class="col-xs-12 search-container" ng-if="price.active_add">
		<div class="col-xs-12">
			<div class="title-mid">
				{!! trans('messages.admin_add_price') !!}
			</div>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="price.active_edit">
		<div class="col-xs-12">
			<div class="title-mid">
				{!! trans('messages.admin_update_price') !!}
			</div>
		</div>
	</div>

	<div class="col-xs-12" ng-class="{ 'success-container' : price.active_add || price.active_edit, 'search-container' : !(price.active_add || price.active_edit) }" ng-if="price.errors || price.success">
		<div class="alert alert-error" ng-if="price.errors">
			<p ng-repeat="error in price.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="price.success">
			<p>{! price.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="price.active_add || price.active_edit">
		{!! Form::open(['class'=> 'form-horizontal']) !!}
		<fieldset>
			<div class="form-group">
				<label class="col-xs-3 control-label">{!! trans('messages.admin_subscription_name') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('name', '',
						[
							'class' => 'form-control'
							, 'ng-model' => 'price.record.name'
							, 'ng-class' => "{ 'required-field' : price.fields['name'] }"
							, 'placeholder' => trans('messages.name')
						])
					!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">{!! trans('messages.description') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::textarea('description', '',
						[
							'class' => 'form-control disabled-textarea'
							, 'placeholder' => trans('messages.description')
							, 'rows' => '4'
							, 'ng-model' => 'price.record.description'
							, 'ng-class' => "{ 'required-field' : price.fields['description'] }"
						])
					!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">{!! trans('messages.price') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1">{!! trans('messages.usd') !!}</span>
						  {!! Form::text('total_amount',''
							, [
								'class' => 'form-control'
								, 'ng-model' => 'price.record.price'
								, 'ng-class' => "{ 'required-field' : price.fields['price'] }"
								, 'placeholder' => trans('messages.price')
							]
						) !!}
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">{!! trans('messages.admin_days') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('days','',
						[
							'class' => 'form-control'
							, 'placeholder' => trans('messages.admin_days')
							, 'ng-class' => "{ 'required-field' : price.fields['days'] }"
							, 'ng-model' => 'price.record.days'
						])
					!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="status">{!! trans('messages.status') !!} <span class="required">*</span></label>
				<div class="col-xs-9">
					<div class="col-xs-4 checkbox">
						<label>
						{!! Form::radio('status'
							, 'Enabled'
							, true
							, array(
								'class' => 'field'
								, 'ng-model' => 'price.record.status'
							)
						) !!}
						<span class="lbl padding-8">{!! trans('messages.enabled') !!}</span>
						</label>
					</div>
					<div class="col-xs-5 checkbox">
						<label>
						{!! Form::radio('status'
							, 'Disabled'
							, false
							, array(
								'class' => 'field'
								, 'ng-model' => 'price.record.status'
							)
						) !!}
						<span class="lbl padding-8">{!! trans('messages.disabled') !!}</span>
						</label>
					</div>
				</div>
			 </div>
		   <div class="form-group">
				   <label class="col-xs-3 control-label" id="status">{!! trans('messages.learning_style') !!} <span class="required">*</span></label>
				   <div class="col-xs-9">
						   <div class="col-xs-4 checkbox">
								   <label>
										   {!! Form::radio('lsp'
												, '1'
												, false
												, array(
													'class' => 'field',
													'ng-model' => 'price.record.has_lsp'
												)
											) !!}
										   <span class="lbl padding-8">{!! trans('messages.included') !!}</span>
								   </label>
						   </div>
						   <div class="col-xs-5 checkbox">
									<label>
										   {!! Form::radio('lsp'
												, '0'
												, false
												, array(
													'class' => 'field',
													'ng-model' => 'price.record.has_lsp'
												)
											) !!}
										   <span class="lbl padding-8">{!! trans('messages.not_included') !!}</span>

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
							, 'ng-click' => "price.update()"
							, 'ng-if' => 'price.active_edit'
						)
					) !!}

					{!! Form::button(trans('messages.admin_add_price')
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "price.add()"
							, 'ng-if' => 'price.active_add'
						)
					) !!}

					{!! Form::button(trans('messages.cancel')
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "price.setActive()"
						)
					) !!}
				</div>
			</div>
		</fieldset>
	</div>

	<div class="col-xs-12 search-container">
		<button class="btn btn-blue btn-semi-medium" 
			ng-click="price.setActive(futureed.ACTIVE_ADD)"
			ng-if="!(price.active_add || price.active_edit)">
			<span><i class="fa fa-plus-square"></i></span> {!! trans('messages.admin_add_price') !!}
		</button>

		<div class="list-container">
			<div class="col-xs-6 title-mid">
				{!! trans('messages.admin_price_list') !!}
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
						'ng-model' => 'price.table.size'
						, 'ng-change' => 'price.paginateBySize()'
						, 'ng-if' => "price.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
				<tr>
					<th>{!! trans('messages.admin_subscription_name') !!}</th>
					<th>{!! trans('messages.description') !!}</th>
					<th>{!! trans('messages.price') !!}</th>
					<th ng-if="price.records.length">{!! trans('messages.action') !!}</th>
				</tr>
				</thead>
				<tbody>
				<tr ng-repeat="record in price.records">
					<td>{! record.name !}</td>
					<td>{! record.description !}</td>
					<td>{! record.price | currency : "USD$ " : 2 !}</td>
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
								<a href="" ng-click="price.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
							</div>
							<div class="col-xs-4">
								<a href="" ng-click="price.deletePrice(record.id)"><span><i class="fa fa-trash"></i></span></a>
							</div>
						</div>
					</td>
				</tr>
				<tr class="odd" ng-if="!price.records.length">
					<td valign="top" colspan="4">
						{!! trans('messages.no_records_found') !!}
					</td>
				</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="price.records.length">
				<pagination 
					total-items="price.table.total_items" 
					ng-model="price.table.page"
					max-size="3"
					items-per-page="price.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="price.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>