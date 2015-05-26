<div ng-if="sale.edit_price">
	<div class="col-xs-12 edit-price">
		<div class="price-form">
		      		{!! Form::open([
		      			'id' => 'price_form', 
		      			'class'=> 'form-horizontal'
		      			]) 
		      		!!}

		      		{!! Form::hidden('id','',['ng-model' => 'sale.data.id']) !!}
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Name <span class="required">*</span></label>
		      			<div class="col-xs-5">
		      				{!! Form::text('name', '', 
			      				[
			      					'class' => 'form-control', 
			      					'ng-model' => 'sale.data.name', 
			      					'placeholder' => 'Name'
			      				])
			      			!!}
		      			</div>
		      		</div>
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Description <span class="required">*</span></label>
		      			<div class="col-xs-5">
		      				{!! Form::textarea('description', '', 
			      				[
			      					'class' => 'form-control', 
			      					'rows' => '4', 
			      					'style' => 'resize:vertical;', 
			      					'ng-model' => 'sale.data.description'
			      				]) 
			      			!!}
		      			</div>
		      		</div>
		      		<div class="form-group">
		      			<label class="col-xs-2 control-label">Price <span class="required">*</span></label>
		      			<div class="col-xs-5">
		      				{!! Form::text('price','',
		      					[
		      						'class' => 'form-control',
		      						'ng-model' => 'sale.data.price'
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
	                			<button class="btn btn-blue btn-medium" type="button" ng-click="sale.editPrice()">Save</button>
	                			<button class="btn btn-gold btn-medium" type="button" ng-click="sale.cancelEdit('price')">Cancel</button>
	                		</div>
	                	</div>
		      	</div>
	</div>
</div>