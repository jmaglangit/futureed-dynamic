<div ng-if="class.active_view || class.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Class Details</span>
		</div>		
	</div>

	<div class="col-xs-12 success-container" ng-if="class.errors || class.success">
		<div class="alert alert-error" ng-if="class.errors">
            <p ng-repeat="error in class.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="class.success">
            <p>{! class.success !}</p>
        </div>
    </div>

	<div class="col-xs-12 search-container">
		<div class="title-mid"></div>
		{!! Form::open(
			array(
				'id' => 'class_detail_form'
				, 'class' => 'form-horizontal'
			)
		) !!}
			<div class="form-group">
				<label class="col-xs-3 control-label">Class <span class="required">*</span></label>
				<div class="col-xs-5">
					<div ng-class="{ 'input-group' : class.active_view }">
						{!! Form::text('class_name', ''
							, array(
								'ng-disabled'=>'class.active_view'
								, 'class' => 'form-control'
								, 'ng-model' => 'class.record.name'
								, 'placeholder' => 'Class Name'
							)
						) !!}

						<span class="input-group-addon" 
							ng-if="class.active_view"
							ng-click="class.setActive(futureed.ACTIVE_EDIT, class.record.id)"><i class="fa fa-pencil edit-addon"></i></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">Subject</label>
				<div class="col-xs-5">
					{!! Form::text('subject', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'class.record.subject.name'
							, 'placeholder' => 'Subject'
						)
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">Grade</label>
				<div class="col-xs-5">
					{!! Form::text('search_name', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'class.record.grade.name'
							, 'placeholder' => 'Grade'
						)
					) !!}
				</div>
			</div>
		{!! Form::close() !!}

		<div class="btn-container col-xs-5 col-xs-offset-3 margin-10-top" ng-if="class.active_view">
			{!! Form::button('View List'
				, array(
					'class' => 'btn btn-gold btn-large'
					, 'ng-click' => "class.setActive('list')"
				)
			) !!}
		</div>

		<div class="btn-container col-xs-5 col-xs-offset-3 margin-10-top" ng-if="class.active_edit">
			{!! Form::button('Save'
				, array(
					'class' => 'btn btn-blue btn-medium'
					, 'ng-click' => 'class.update()'
				)
			) !!}

			{!! Form::button('Cancel'
				, array(
					'class' => 'btn btn-gold btn-medium'
					, 'ng-click' => "class.setActive('view')"
				)
			) !!}
		</div>
	</div>

	<div class="col-xs-12 search-container">
		<div class="title-mid">
			Search
		</div>

		<div class="form-search">
			{!! Form::open(
				array(
					  'id' => 'search_form'
					, 'class' => 'form-horizontal'
					, 'ng-submit' => 'class.searchFnc($event)'
				)
			) !!}
				<div class="form-group">
					<div class="col-xs-4">
						{!! Form::text('name', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'class.search.name'
								, 'placeholder' => 'Name'
							)
						) !!}
					</div>
					<div class="col-xs-4">
						{!! Form::text('email', ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'class.search.email'
								, 'placeholder' => 'Email'
							)
						) !!}
					</div>
					<div class="col-xs-2">
						{!! Form::button('Search'
							, array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'class.searchFnc($event)'
							)
						) !!}
					</div>
					<div class="col-xs-2">
						{!! Form::button('Clear'
							, array(
								'class' => 'btn btn-gold'
								, 'ng-click' => 'class.clear()'
							)
						) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-12 table-container">
		<button class="btn btn-blue btn-small" type="button" ng-click="class.setActive('add_student')">
			<i class="fa fa-plus-square"></i> Add Student
		</button>

		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				Student List
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
						'ng-model' => 'class.table.size'
						, 'ng-change' => 'class.paginateBySize()'
						, 'ng-if' => "class.students.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
			        <tr>
			            <th>Student's Name</th>
			            <th class="width-medium">Email</th>
			            <th ng-if="class.students.length">Action</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="student in class.students">
			            <td>{! student.student.user.name !}</td>
			            <td>{! student.student.user.email !}</td>
			            <td ng-if="class.students.length">
			            	<div class="row">
		    					<div class="col-xs-12">
		    						<a href="" ng-click="class.confirmDeleteStudent(student.id)"><span><i class="fa fa-trash"></i></span></a>
		    					</div>
			            	</div>
			            </td>
			        </tr>
			        <tr class="odd" ng-if="!class.students.length">
			        	<td valign="top" colspan="3">
			        		No records found.
			        	</td>
			        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="class.students.length">
				<pagination 
					total-items="class.table.total_items" 
					ng-model="class.table.page"
					max-size="3"
					items-per-page="class.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="class.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div>
		<div template-directive template-url="{!! route('client.teacher.tips.index') !!}"></div>
	</div>
</div>
<div id="delete_student_modal" ng-show="class.delete_student_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	        <div class="modal-header">
	            Delete Student
	        </div>
	        <div class="modal-body center-date">
			    <div class="alert alert-error" ng-if="class.delete_student.errors">
		            <p ng-repeat="error in class.delete_student.errors track by $index" > 
		              	{! error !}
		            </p>
		        </div>
	            <input type="hidden" id="delete_date">
	        </div>
	        <div class="modal-footer">
	        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
	                {!! Form::button('Delete'
	                    , array(
	                        'class' => 'btn btn-blue btn-medium'
	                        , 'ng-click' => 'class.deleteStudent(class.delete_student_id)'
	                    )
	                ) !!}

	                {!! Form::button('Cancel'
	                    , array(
	                        'class' => 'btn btn-gold btn-medium'
	                        , 'data-dismiss' => 'modal'
	                        , 'ng-click' => 'class.cancelDeleteStudent()'
	                    )
	                ) !!}
	        	</div>
	        </div>
	    </div>
  	</div>
</div>