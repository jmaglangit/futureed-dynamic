<div ng-if="payment.add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Payment</span>
		</div>
	</div>
	{!! Form::open(array('id'=> 'add_payment_form', 'class' => 'form-horizontal')) !!}
	<div class="form-content col-xs-12">
		<div class="alert alert-error" ng-if="subject.errors">
	            <p ng-repeat="error in subject.errors track by $index" > 
	              	{! error !}
	            </p>
	        </div>

	        <div class="alert alert-success" ng-if="subject.create.success">
	        	<p>Successfully added new subject.</p>
	        </div>
	        <fieldset>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="email">Email<span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('Email',''
	        				, array(
	        					'placeHolder' => 'Email'
	        					, 'ng-model' => 'subject.create.code'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<div class="col-xs-3">
	        			<div class="btn-container">
	        				<button class="btn btn-blue btn-medium margin-0-top"><span><i class="fa fa-plus-square"></i></span> Add</button>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<div class="col-xs-8">
	        			<center><b>OR</b></center>
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="name">Name<span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('name',''
	        				, array(
	        					'placeHolder' => 'Name'
	        					, 'ng-model' => 'payment.name'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<div class="col-xs-3">
	        			<div class="btn-container">
	        				<button class="btn btn-blue btn-medium margin-0-top"><span><i class="fa fa-plus-square"></i></span> Add</button>
	        			</div>
	        		</div>
	        	</div>
	        </fieldset>
	</div>
	{!! Form::close() !!}
	<div class="col-xs-12">
		<div class="table-form">
			<div class="form-group">
				<div class="col-xs-3">
					<div class="col-xs-6">
						<b>Item</b>
					</div>
					<div class="col-xs-6">
						Subscription
					</div>	
				</div>
				<div class="col-xs-3">
					{!! Form::select('subscription',[''=>'-- Select Subscription --','120 days'=>'120 days','240 days'=>'240 days','480 days'=> '480 days'],null,['class' => 'form-control', 'ng-model' => 'teacher.search_email', 'placeholder' => 'Email']) !!}
				</div>
				<div class="col-xs-6">
					<label class="col-xs-2 control-label">Starting</label>
					<div class="col-xs-4">
						{!! Form::text('search_name', '',['class' => 'form-control', 'ng-model' => 'teacher.search_name', 'placeholder' => 'Name']) !!}
					</div>
					<label class="col-xs-2 control-label">To</label>
					<div class="col-xs-4">
						{!! Form::text('search_name', '',['class' => 'form-control', 'ng-model' => 'teacher.search_name', 'placeholder' => 'Name']) !!}
					</div>
				</div>
			</div>
			<div class="form-group margin-top-60">
				<table class="table table-bordered">
					<thead>
						<tr>
							<td>Name</td>
							<td>Email</td>
							<td>Price</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
						<tr>
						{{-- Sample Data --}}
							<td>Bart Simpson</td>
							<td>bart.simspon@springfield.com</td>
							<td>5</td>
							<td>
								<a href="#">Remove</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="row margin-10-bot">
				<div class="col-xs-4 div-right">
					<label class="col-xs-4 control-label">Sub Total</label>
					<div class="col-xs-8">
						{!! Form::text('subtotal','',['disabled' => 'disabled','class' => 'form-control']) !!}
					</div>
				</div>
			</div>
			<div class="row margin-10-bot">
				<div class="col-xs-4 div-right">
					<label class="col-xs-4 control-label">Discount</label>
					<div class="col-xs-8">
						{!! Form::text('discount','',['disabled' => 'disabled','class' => 'form-control']) !!}
					</div>
				</div>
			</div>
			<div class="row margin-10-bot">
				<div class="col-xs-4 div-right">
					<label class="col-xs-4 control-label">Total</label>
					<div class="col-xs-8">
						{!! Form::text('total','',['disabled' => 'disabled','class' => 'form-control']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 margin-30-bot">
		<div class="col-xs-5 div-right">
			<div class="btn-container">
				<button class="btn btn-blue btn-semi-large">Pay Subscription</button>
				<button class="btn btn-gold btn-medium" ng-click="payment.setActive('list')">Cancel</button>
			</div>
		</div>
	</div>
</div>