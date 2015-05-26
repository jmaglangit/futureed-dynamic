<div ng-if="sale.bulk_edit">
	<div class="col-xs-12">
		<div class="bulk-form">
			{!! Form::open(['id' => 'bulk-form', 'class' => 'form-horizontal']) !!}
			{!! Form::hidden('id','',['ng-model' => 'sale.data.id']) !!}
			<div class="form-group">
					<label class="col-xs-2 control-label">Bulk Number <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('min_seats', '',
							[
								'class' => 'form-control',
								'ng-model' => 'sale.data.min_seats',
								'placeholder' => 'Bulk Number'
							]) 
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Discount <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('percentage', '',
							[
								'class' => 'form-control',
								'ng-model' => 'sale.data.percentage',
								'placeholder' => 'Discount'
							]) 
						!!}
					</div>
				</div>
				<div class="form-group">
	                <label class="col-xs-2 control-label" id="status">Status <span class="required">*</span></label>
	                <div class="col-xs-5">
	                	<div class="col-xs-6 checkbox">	                				
	                		<label>
	                		{!! Form::radio('status','Enabled', ( '{!sale.data.status!}' == 'Enabled' ) ? true : false, 
	                					[
	                						'class' => 'field', 
	                						'ng-model'=> 'sale.data.status'
	                					]) 
	                				!!}
	                		<span class="lbl padding-8">Enabled</span>
	                		</label>
	                	</div>
	                	<div class="col-xs-6 checkbox">
	                		<label>
	                		{!! Form::radio('status', 'Disabled', ( '{!sale.data.status!}' == 'Disabled' ) ? true : false, 
	                					[
	                						'class' => 'field', 
	                						'ng-model'=> 'sale.data.status'
	                					]) 
	                				!!}
	                		<span class="lbl padding-8">Disabled</span>
	                		</label>
	                	</div>
	                </div>
	            </div>
	            <div class="col-xs-7">
	                <div class="btn-container">
	                	<button class="btn btn-blue btn-medium" type="button" ng-click="sale.editBulk()">Add</button><button class="btn btn-gold btn-medium" type="button" ng-click="sale.cancelEdit('bulk')">Cancel</button>
	                </div>
	            </div>
		</div>
	</div>
</div>