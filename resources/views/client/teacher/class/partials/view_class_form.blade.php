<div ng-if="class.active_view">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Class</span>
		</div>		
	</div>
	{!! Form::open(
					[
						'id' => 'teacher_search',
						'class' => 'form-horizontal'
					]
			) !!}
		<div class="mid-container top-margin">
			<div class="form-group">
				<label class="col-xs-2 control-label">Class</label>
				<div class="col-xs-5">
					{!! Form::text('search_name', '',['ng-disabled'=>'true','class' => 'form-control', 'ng-model' => 'teacher.search_name', 'placeholder' => 'Name']) !!}
				</div>
				<div class="col-xs-2">
					<a href="#" ng-click="class.setActive('edit')" class="edit-class">Edit Class</a>
				</div>
				
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Grade</label>
				<div class="col-xs-5">
					{!! Form::text('search_name', '',['ng-disabled'=>'true',	'class' => 'form-control', 'ng-model' => 'teacher.search_name', 'placeholder' => 'Name']) !!}
				</div>
			</div>
		</div>
		<div class="col-xs-12 mid-container">
			<div class="title-mid">
				Student List
			</div>
		</div>
		<div class="col-xs-12 search-container">
		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'class_search',
						'class' => 'form-horizontal'
					]
			) !!}
			<div class="form-group">
				<label class="col-xs-2 control-label">Name</label>
				<div class="col-xs-5">
					{!! Form::text('search_name', '',['class' => 'form-control', 'ng-model' => 'class.search_name', 'placeholder' => 'Name']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Email <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_email', '',['class' => 'form-control', 'ng-model' => 'class.search_email', 'placeholder' => 'Email']) !!}
				</div>
				<div class="btn-container col-xs-5">
					<button class="btn btn-blue btn-medium" type="button" ng-click="class.getClassList()">Search</button>
					<button class="btn btn-gold btn-medium" type="button" ng-click="class.clearSearch()">Clear</button>
				</div>
			</div>
		</div>
	</div>
	<button class="btn btn-blue btn-small margin-0-30" type="button" ng-click="class.setActive('add')">
		<i class="fa fa-plus-square"></i> Add 
	</button>
	<div class="col-xs-12 table-container" ng-init="teacher.getTeacherList()">
		<div class="list-container" ng-cloak>
			<table id="client-list" datatable="ng" class="table table-striped table-hover dt-responsive">
			<thead>
		        <tr>
		            <th>Student's Name</th>
		            <th>Email</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="t in teacher.teacherinfo">
		            <td>{! t.first_name !} {! t.last_name !}</td>
		            <td>{! t.user.email !}</td>
		        </tr>
	        	</tbody>

			</table>
		</div>
	</div>
	<div class="col-xs-12 mid-container">
			<div class="title-mid">
				Tips
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
				<label class="col-xs-2 control-label">Title</label>
				<div class="col-xs-5">
					{!! Form::text('search_title', '',['class' => 'form-control', 'ng-model' => 'class.search_title', 'placeholder' => 'Title']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::select('search_status',[''=>'-- Select Status --','Verified'=>'Verified','Not Verified'=>'Not Verified'],null,['class' => 'form-control', 'ng-model' => 'teacher.search_email', 'placeholder' => 'Email']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Created</label>
				<div class="col-xs-5">
					{!! Form::text('search_created', '',['class' => 'form-control', 'ng-model' => 'class.search_created', 'placeholder' => 'Created']) !!}
				</div>
				<div class="btn-container col-xs-5">
					<button class="btn btn-blue btn-medium" type="button" ng-click="teacher.getTeacherList()">Search</button>
					<button class="btn btn-gold btn-medium" type="button" ng-click="teacher.clearSearch()">Clear</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 table-container" ng-init="teacher.getTeacherList()">
		<div class="list-container" ng-cloak>
			<table id="client-list" datatable="ng" class="table table-striped table-hover dt-responsive">
			<thead>
		        <tr>
		            <th>Title</th>
		            <th>Description</th>
		            <th>Created By</th>
		            <th>Time Created</th>
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
				            	</div>
						        </div>
				            </td>
		        </tr>
	        	</tbody>

			</table>
		</div>
	</div>
	<div class="col-xs-12 mid-container">
			<div class="title-mid">
				Help Request
			</div>
		</div>
	<div class="col-xs-12 search-container">
		<div class="form-search">
			{!! Form::open(
					[
						'id' => 'help_request',
						'class' => 'form-horizontal'
					]
			) !!}
			<div class="form-group">
				<label class="col-xs-2 control-label">Title</label>
				<div class="col-xs-5">
					{!! Form::text('search_title', '',['class' => 'form-control', 'ng-model' => 'class.search_title', 'placeholder' => 'Title']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::select('search_status',[''=>'-- Select Status --','Verified'=>'Verified','Not Verified'=>'Not Verified'],null,['class' => 'form-control', 'ng-model' => 'teacher.search_email', 'placeholder' => 'Email']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Created</label>
				<div class="col-xs-5">
					{!! Form::text('search_created', '',['class' => 'form-control', 'ng-model' => 'class.search_created', 'placeholder' => 'Created']) !!}
				</div>
				<div class="btn-container col-xs-5">
					<button class="btn btn-blue btn-medium" type="button" ng-click="teacher.getTeacherList()">Search</button>
					<button class="btn btn-gold btn-medium" type="button" ng-click="teacher.clearSearch()">Clear</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 table-container" ng-init="teacher.getTeacherList()">
		<div class="list-container" ng-cloak>
			<table id="client-list" datatable="ng" class="table table-striped table-hover dt-responsive">
			<thead>
		        <tr>
		            <th>Title</th>
		            <th>Description</th>
		            <th>Created By</th>
		            <th>Time Created</th>
		            <th>Time of Last Answer</th>
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
				            	</div>
						        </div>
				            </td>
		        </tr>
	        	</tbody>

			</table>
		</div>
	</div>
</div>