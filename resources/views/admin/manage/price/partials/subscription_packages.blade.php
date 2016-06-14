<div ng-if="package.active_list">
	<div class="col-xs-12 search-container" ng-if="package.active_add">
		<div class="col-xs-12">
			<div class="title-mid">
				{!! trans('messages.add_package') !!}
			</div>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="package.active_edit">
		<div class="col-xs-12">
			<div class="title-mid">
				{!! trans('messages.update_package') !!}
			</div>
		</div>
	</div>

	<div class="col-xs-12" ng-class="{ 'success-container' : package.active_add || package.active_edit, 'search-container' : !(package.active_add || package.active_edit) }" ng-if="package.errors || package.success">
		<div class="alert alert-error" ng-if="package.errors">
			<p ng-repeat="error in package.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="package.success">
			<p>{! package.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="package.active_add || package.active_edit">
		{!! Form::open(['class'=> 'form-horizontal']) !!}
		<fieldset>
			{{--subject--}}
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.subject') !!} <span class="required">*</span></label>
				<div class="col-xs-5" ng-init="package.getSubject()">
					<select ng-disabled="package.active_view" name="subject_id" class="form-control" name="subject_id" ng-model="package.record.subject_id" ng-change="package.setSubject()" ng-class="{'required-field' : package.fields['subject_id']}">
						<option ng-selected="package.record.subject.id == futureed.FALSE" value="">{!! trans('messages.select_subject') !!}</option>
						<option ng-selected="package.record.subject_id == subject.id" ng-repeat="subject in package.subjects" ng-value="subject.id">{! subject.name!}</option>
					</select>
				</div>
			</div>
			{{--subscription --}}
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.subscription') !!} <span class="required">*</span></label>
				<div class="col-xs-5" ng-init="package.getSubscriptions()">
					<select ng-disabled="package.active_view" name="subscription_id" class="form-control" name="subscription_id" ng-model="package.record.subscription_id" ng-change="package.setSubscription()" ng-class="{'required-field' : package.fields['subscription_id']}">
						<option ng-selected="package.record.subscription.id == futureed.FALSE" value="">{!! trans('messages.select_subscription') !!}</option>
						<option ng-selected="package.record.subscription_id == subscription.id" ng-repeat="subscription in package.subscriptions" ng-value="subscription.id">{! subscription.name!}</option>
					</select>
				</div>
			</div>
			{{--country--}}
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.country') !!} <span class="required">*</span></label>
				<div class="col-xs-5" ng-init="package.getCountries()">
					<select ng-disabled="package.active_view" name="country_id" class="form-control" name="country_id" ng-model="package.record.country_id" ng-change="package.setCountry()" ng-class="{'required-field' : package.fields['country_id']}">
						<option ng-selected="package.record.country.id == futureed.FALSE" value="">{!! trans('messages.select_country') !!}</option>
						<option ng-selected="package.record.country_id == country.id" ng-repeat="country in package.countries" ng-value="country.id">{! country.name!}</option>
					</select>
				</div>
			</div>
			{{--subscription days--}}
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.admin_days') !!} <span class="required">*</span></label>
				<div class="col-xs-5" ng-init="package.getSubscriptionDays()">
					<select ng-disabled="package.active_view" name="days_id" class="form-control" name="days_id" ng-model="package.record.days_id" ng-change="package.setSubscriptionDay()" ng-class="{'required-field' : package.fields['days_id']}">
						<option ng-selected="package.record.subscription_day.id == futureed.FALSE" value="">{!! trans('messages.select_days') !!}</option>
						<option ng-selected="package.record.days_id == subscription_day.id" ng-repeat="subscription_day in package.subscription_days" ng-value="subscription_day.id">{! subscription_day.days !} {!! trans('messages.admin_days') !!}</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">{!! trans('messages.price') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('price', '',
						[
							'class' => 'form-control'
							, 'ng-model' => 'package.record.price'
							, 'ng-class' => "{ 'required-field' : package.fields['price'] }"
							, 'placeholder' => trans('messages.price')
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
								, 'ng-model' => 'package.record.status'
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
								, 'ng-model' => 'package.record.status'
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
							, 'ng-click' => "package.update()"
							, 'ng-if' => 'package.active_edit'
						)
					) !!}

					{!! Form::button(trans('messages.add_package')
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "package.add()"
							, 'ng-if' => 'package.active_add'
						)
					) !!}

					{!! Form::button(trans('messages.cancel')
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "package.setActive(futureed.ACTIVE_CANCEL)"
						)
					) !!}
				</div>
			</div>
		</fieldset>
	</div>

	<div class="col-xs-12 search-container">
		<button class="btn btn-blue btn-semi-medium" 
			ng-click="package.setActive(futureed.ACTIVE_ADD)"
			ng-if="!(package.active_add || package.active_edit)">
			<span><i class="fa fa-plus-square"></i></span> {!! trans('messages.add_package') !!}
		</button>

		<div class="list-container">
			<div class="col-xs-6 title-mid">
				{!! trans('messages.subscription_packages') !!}
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
						'ng-model' => 'package.table.size'
						, 'ng-change' => 'package.paginateBySize()'
						, 'ng-if' => "package.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
				<tr>
					<th>{!! trans('messages.subject') !!}</th>
					<th>{!! trans('messages.subscription') !!}</th>
					<th>{!! trans('messages.country') !!}</th>
					<th>{!! trans('messages.admin_days') !!}</th>
					<th>{!! trans('messages.price') !!}</th>
					<th ng-if="package.records.length">{!! trans_choice('messages.action', 2) !!}</th>
				</tr>
				</thead>
				<tbody>
				<tr ng-repeat="record in package.records">
					<td>{! record.subject.name !}</td>
					<td>{! record.subscription.name !}</td>
					<td>{! record.country.name !}</td>
					<td>{! record.subscription_day.days !}</td>
					<td>{! record.price !}</td>
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
								<a href="" ng-click="package.setActive(futureed.ACTIVE_EDIT, record.id)"><span><i class="fa fa-pencil"></i></span></a>
							</div>
							<div class="col-xs-4">
								<a href="" ng-click="package.delete(record.id)"><span><i class="fa fa-trash"></i></span></a>
							</div>
						</div>
					</td>
				</tr>
				<tr class="odd" ng-if="!package.records.length">
					<td valign="top" colspan="4">
						{!! trans('messages.no_records_found') !!}
					</td>
				</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="package.records.length">
				<pagination 
					total-items="package.table.total_items"
					ng-model="package.table.page"
					max-size="3"
					items-per-page="package.table.size"
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="package.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>