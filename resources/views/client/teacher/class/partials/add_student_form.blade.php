<div>
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Student</span>
		</div>
	</div>
	<div class="col-xs-12 search-container">
		{!! Form::open(
			[
				'id' => 'add_student',
				'class' => 'form-horizontal'
			]
		) !!}
		<div class="form-group">
				<div class="col-xs-2">
					<input type="checkbox" ng-click="class.exist">
					<label class="control-label">Existing Email</label>
				</div>
				<div class="col-xs-5">
					{!! Form::text('search_name', '',['class' => 'form-control', 'ng-model' => 'teacher.search_name', 'placeholder' => 'Name']) !!}
				</div>
		</div>
	</div>

</div>