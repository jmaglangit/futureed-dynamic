<div>
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
	        		<label class="col-xs-2 control-label" id="email">Number of Seats <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('code',''
	        				, array(
	        					'placeHolder' => 'Number of Seats'
	        					, 'ng-model' => 'subject.create.code'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group" ng-init="getGradeLevel()">
	        		<label class="col-xs-2 control-label">Grade <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			<select name="grade_code" class="form-control" ng-model="reg.grade_code">
                            <option value="">-- Select Level --</option>
                            <option ng-repeat="grade in grades" value="{! grade.code !}">{! grade.name !}</option>
                        </select>
	        		</div>		
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="email">Teacher <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('teacher',''
	        				, array(
	        					'placeHolder' => 'Teacher'
	        					, 'ng-model' => 'subject.create.code'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="email">Grade <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('grade',''
	        				, array(
	        					'placeHolder' => 'Grade'
	        					, 'ng-model' => 'subject.create.code'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="btn-container col-xs-offset-2 col-xs-5">
	        		<button class="btn btn-blue btn-medium" type="button"><span><i class="fa fa-plus-square"></i></span> Add</button>
	        		<button class="btn btn-gold btn-medium" type="button">Cancel</button>

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
							<td>Number of Seats</td>
							<td>Grade</td>
							<td>Teacher</td>
							<td>Class</td>
							<td>Price</td>
							<td>Actions</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>200</td>
							<td>K1</td>
							<td>Edna Krabappel</td>
							<td>Edna-K1</td>
							<td>15</td>
							<td><a href="#">Remove</a></td>
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
				<button class="btn btn-gold btn-medium">Cancel</button>
			</div>
		</div>
	</div>
</div>