<div ng-if="bulk.active_list">
	<div class="col-xs-12 search-container" ng-if="bulk.active_add">
		<div class="title-mid">
			Add Bulk Discount
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="bulk.active_edit">
		<div class="title-mid">
			Update Bulk Discount
		</div>
	</div>

	<div class="col-xs-12" ng-class="{ 'success-container' : bulk.active_add || bulk.active_edit, 'search-container' : !(bulk.active_add || bulk.active_edit) }" ng-if="bulk.errors || bulk.success">
		<div class="alert alert-error" ng-if="bulk.errors">
			<p ng-repeat="error in bulk.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="bulk.success">
			<p>{! bulk.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container" ng-if="bulk.active_add || bulk.active_edit">
		{!! Form::open(['class'=> 'form-horizontal']) !!}
			<fieldset>
				<div class="form-group">
					<label class="col-xs-3 control-label">Minimum Seats <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('min_seats', '',
							[
								'class' => 'form-control'
								, 'ng-model' => 'bulk.record.min_seats'
								, 'ng-class' => "{ 'required-field' : bulk.fields['min_seats'] }"
								, 'placeholder' => 'Minimum Seats'
							]) 
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">bulk <span class="required">*</span></label>
					<div class="col-xs-5">
						<div class="input-group">
							{!! Form::text('percentage', '',
								[
									'class' => 'form-control'
									, 'ng-model' => 'bulk.record.percentage'
									, 'ng-class' => "{ 'required-field' : bulk.fields['percentage'] }"
									, 'placeholder' => 'bulk'
								]) 
							!!}
							<span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Status <span class="required">*</span></label>
					<div class="col-xs-5">
						<div class="col-xs-6 checkbox">	                				
							<label>
							{!! Form::radio('status'
								, 'Enabled'
								, true
								, array(
									'class' => 'field'
									, 'ng-model' => 'bulk.record.status'
								) 
							) !!}
							<span class="lbl padding-8">Enabled</span>
							</label>
						</div>
						<div class="col-xs-6 checkbox">
							<label>
							{!! Form::radio('status'
								, 'Disabled'
								, false
								, array(
									'class' => 'field'
									, 'ng-model' => 'bulk.record.status'
								) 
							) !!}
							<span class="lbl padding-8">Disabled</span>
							</label>
						</div>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<div class="btn-container col-xs-9 col-xs-offset-1">
						{!! Form::button('Update'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "bulk.update()"
								, 'ng-if' => 'bulk.active_edit'
							)
						) !!}

						{!! Form::button('Add Bulk Discount'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "bulk.add()"
								, 'ng-if' => 'bulk.active_add'
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "bulk.setActive()"
							)
						) !!}
					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>

	<div class="col-xs-12 search-container">
		<button class="btn btn-blue btn-semi-medium" 
			ng-click="bulk.setActive(futureed.ACTIVE_ADD)"
			ng-if="!(bulk.active_add || bulk.active_edit)">
			<span><i class="fa fa-plus-square"></i></span> Add Bulk Discount
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				Bulk List
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
						'ng-model' => 'bulk.table.size'
						, 'ng-change' => 'bulk.paginateBySize()'
						, 'ng-if' => "bulk.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>Minimum Seats</th>
						<th>bulk</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="b in bulk.records">
						<td>{! b.min_seats !}</td>
						<td>{! b.percentage | percent !}</td>
						<td>
							<div class="row">
								<div class="col-xs-4">
									<i class="fa" 
										ng-class="{ 'fa-ban error-icon' : b.status == futureed.DISABLED, 'fa-check-circle-o success-icon' : b.status == futureed.ENABLED }"
										tooltip="{! b.status !}"
										tooltip-placement="top"
										tooltip-trigger="mouseenter"></i>
								</div>
								<div class="col-xs-4">
									<a href="" ng-click="bulk.getBulk(b.id)"><span><i class="fa fa-pencil"></i></span></a>
								</div>
								<div class="col-xs-4">
									<a href="" ng-click="bulk.deleteBulk(b.id)"><span><i class="fa fa-trash"></i></span></a>
								</div>
							</div>
						</td>
					</tr>
					<tr class="odd" ng-if="!bulk.records.length">
							<td valign="top" colspan="4">
								No records found
							</td>
						</tr>
				</tbody>
			</table>
			<div class="pull-right" ng-if="bulk.records.length">
				<pagination 
					total-items="bulk.table.total_items" 
					ng-model="bulk.table.page"
					max-size="3"
					items-per-page="bulk.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="bulk.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>