<div>
	<div class="content-title">
		<div class="title-main-content">
			<span>Invoice Management</span>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-xs-3 margin-30-top margin-60-left">
				{{-- Sample data --}}
				<center><b>Springfield Elementary School</b></center>
			</div>
			<div class="col-xs-3 div-right margin-30-top">
				<button class="btn btn-blue btn-medium"><span><i class="fa fa-print"></i></span> Print</button>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-3 margin-60-left">
				{{-- Sample Data --}}
				<center>
					<i>Contant Name: Mr. Seymour</i><br/>
					<i>Address: 19 Springfield Avenue</i><br/>
					<i>Springfield 09878</i><br/>
					<i>USA</i><br/>
				</center>
			</div>
		</div>
		<div class="col-xs-10 margin-side margin-30-top">
			<label class="col-xs-2 control-label">Invoice #</label>
			<div class="col-xs-4">
				{!! Form::text('class_name', '',['disabled'=>'disabled','class' => 'form-control', 'ng-model' => 'class.class_name', 'placeholder' => 'Order #']) !!}
			</div>
			<label class="col-xs-2 control-label">Subscription</label>
			<div class="col-xs-4">
				{!! Form::select('gender',
						[
							'' => '-- Select Subscription --',
							'3 months' => '3 months',
							'6 months' => '6 months',
							'12 months' => '12 months'
						], null,
						['disabled' => 'disabled','ng-model' => 'payment.search_subscription', 'class' => 'form-control']
					)!!}
			</div>
		</div>
		<div class="col-xs-10 margin-side margin-30-top">
			<label class="col-xs-2 control-label">Date Started</label>
			<div class="col-xs-4">
				{!! Form::text('date_start', '',['disabled'=>'disabled','class' => 'form-control', 'ng-model' => 'class.class_name', 'placeholder' => 'Date Started']) !!}
			</div>
			<label class="col-xs-2 control-label">Date End</label>
			<div class="col-xs-4">
				{!! Form::text('date_end', '',['disabled'=>'disabled','class' => 'form-control', 'ng-model' => 'class.class_name', 'placeholder' => 'Date End']) !!}
			</div>
		</div>
		<div class="col-xs-12">
			<div class="form-group margin-top-60">
				<table class="table table-bordered">
					<thead>
						<tr>
							<td>Number of Seats</td>
							<td>Grade</td>
							<td>Teacher</td>
							<td>Class</td>
							<td>Price</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>200</td>
							<td>K1</td>
							<td>Edna Krabappel</td>
							<td>Edna-K1</td>
							<td>15</td>
						</tr>
					</tbody>
				</table>
			</div>
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
			<div class="col-xs-12 margin-30-bot">
		<div class="col-xs-6 div-right">
			<div class="btn-container">
				<button class="btn btn-blue btn-semi-large">Pay Subscription</button>
				<button class="btn btn-gold btn-medium">Cancel</button>
			</div>
		</div>
	</div>
	</div>
</div>