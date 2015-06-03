<div ng-if="invoice.list_form">
	<div class="content-title">
		<div class="title-main-content">
			<span>Invoice Management</span>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="title-mid mid-container">
			Search
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'teacher_search',
						'class' => 'form-horizontal'
					]
			) !!}
			<div class="form-group">
				<label class="col-xs-2 control-label">Order # <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_order', '',['class' => 'form-control', 'ng-model' => 'invoice.search_order', 'placeholder' => 'Order No.']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Subscription Name <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_name', '',['class' => 'form-control', 'ng-model' => 'invoice.search_name', 'placeholder' => 'Subscription Name']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::select('search_status',[''=>'-- Select Status --','Pending'=>'Pending','Paid'=>'Paid','Cancelled'=> 'Cancelled'],null,['class' => 'form-control', 'ng-model' => 'teacher.search_email', 'placeholder' => 'Email']) !!}
				</div>
				<div class="btn-container col-xs-5">
					<button class="btn btn-blue btn-medium" type="button" ng-click="teacher.getTeacherList()">Search</button>
					<button class="btn btn-gold btn-medium" type="button" ng-click="teacher.clearSearch()">Clear</button>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 mid-container">
		<div class="title-mid">
			Invoice List
		</div>
	</div>
	<div class="col-xs-12 table-container" ng-init="teacher.getTeacherList()">
		<div class="list-container" ng-cloak>
			<table id="client-list" datatable="ng" class="table table-striped table-hover dt-responsive">
			<thead>
		        <tr>
		            <th>Order #</th>
		            <th>Subscription Name</th>
		            <th>Date Started</th>
		            <th>Date End</th>
		            <th>Total # of Seats</th>
		            <th>Total Price</th>
		            <th>Status</th>
		            <th>Action</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="t in teacher.teacherinfo">
		            <td>{! t.first_name !} {! t.last_name !}</td>
		            <td>{! t.user.email !}</td>
		            <td>{! t.user.email !}</td>
		            <td>{! t.user.email !}</td>
		            <td>{! t.user.email !}</td>
		            <td>{! t.user.email !}</td>
		            <td>{! t.user.email !}</td>
		            <td width="250px">
				            	<div class="col-xs-12">
				            		<div class="row price-action">
					            		<div class="col-action">
					            			<a href="" ng-click="teacher.viewTeacher(t.id)">View</a>
					            		</div>
					            		<span class="separator">|</span>
					            		<div class="col-action">
					            			<a href="" ng-click="admin.editAdmin(a.id)">Edit</a>
					            		</div>
					            		<span class="separator">|</span>
					            		<div class="col-action">
					            			<a href="" ng-click="sale.deletePrice(p.id)">Remove</a>
					            		</div>
				            	</div>
						        </div>
				            </td>
		        </tr>
	        </tbody>

			</table>
		</div>
	</div>
</div>