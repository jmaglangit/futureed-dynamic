<div ng-if="days.active_list">
	<div class="col-xs-12 search-container" ng-if="days.active_add">
		<div class="col-xs-12">
			<div class="title-mid">
				{!! trans('messages.add_days') !!}
			</div>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="days.active_edit">
		<div class="col-xs-12">
			<div class="title-mid">
				{!! trans('messages.update_days') !!}
			</div>
		</div>
	</div>

	<div class="col-xs-12" ng-class="{ 'success-container' : days.active_add || days.active_edit, 'search-container' : !(days.active_add || days.active_edit) }" ng-if="days.errors || days.success">
		<div class="alert alert-error" ng-if="days.errors">
			<p ng-repeat="error in days.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="days.success">
			<p>{! days.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="days.active_add || days.active_edit">
		{!! Form::open(['class'=> 'form-horizontal']) !!}
		<fieldset>
			<div class="form-group">
				<label class="col-xs-3 control-label">{!! trans('messages.subscription_days') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('days', '',
						[
							'class' => 'form-control'
							, 'ng-model' => 'days.record.days'
							, 'ng-class' => "{ 'required-field' : days.fields['days'] }"
							, 'placeholder' => trans('messages.admin_days')
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
								, 'ng-model' => 'days.record.status'
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
								, 'ng-model' => 'days.record.status'
							)
						) !!}
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
							, 'ng-click' => "days.update()"
							, 'ng-if' => 'days.active_edit'
						)
					) !!}

					{!! Form::button(trans('messages.add_days')
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "days.add()"
							, 'ng-if' => 'days.active_add'
						)
					) !!}

					{!! Form::button(trans('messages.cancel')
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "days.setActive(futureed.ACTIVE_CANCEL)"
						)
					) !!}
				</div>
			</div>
		</fieldset>
	</div>

	<div class="col-xs-12 search-container">
		<button class="btn btn-blue btn-semi-medium" 
			ng-click="days.setActive(futureed.ACTIVE_ADD)"
			ng-if="!(days.active_add || days.active_edit)">
			<span><i class="fa fa-plus-square"></i></span> {!! trans('messages.add_days') !!}
		</button>

		<div class="list-container">
			<div class="col-xs-6 title-mid">
				{!! trans('messages.subscription_days') !!}
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
						'ng-model' => 'days.table.size'
						, 'ng-change' => 'days.paginateBySize()'
						, 'ng-if' => "days.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
				<tr>
					<th>{!! trans('messages.admin_days') !!}</th>
					<th ng-if="days.records.length">{!! trans_choice('messages.action', 2) !!}</th>
				</tr>
				</thead>
				<tbody>
				<tr ng-repeat="record in days.records">
					<td>{! record.days !}</td>
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
								<a href="" ng-click="days.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
							</div>
							<div class="col-xs-4">
								<a href="" ng-click="days.delete(record.id)"><span><i class="fa fa-trash"></i></span></a>
							</div>
						</div>
					</td>
				</tr>
				<tr class="odd" ng-if="!days.records.length">
					<td valign="top" colspan="4">
						{!! trans('messages.no_records_found') !!}
					</td>
				</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="days.records.length">
				<pagination 
					total-items="days.table.total_items"
					ng-model="days.table.page"
					max-size="3"
					items-per-page="days.table.size"
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="days.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>