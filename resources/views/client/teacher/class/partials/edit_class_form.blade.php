<div ng-if="class.edit_form">
	<div class="content-title">
		<div class="title-main-content">
			<span>Edit Class</span>
		</div>
	</div>
	{!! Form::open(
		[
			'id' => 'class_edit',
			'class' => 'form-horizontal'
		]
	) !!}
	<div class="form-group top-margin">
		<label class="col-xs-2 control-label">Class Name <span class="required">*</span></label>
		<div class="col-xs-5">
			{!! Form::text('class_name', '',['class' => 'form-control', 'ng-model' => 'class.class_name', 'placeholder' => 'Class Name']) !!}
		</div>
	</div>

	<div class="btn-container col-xs-4 col-xs-offset-3">
		<button class="btn btn-blue btn-medium" type="button" ng-click="teacher.getTeacherList()">Save</button>
		<button class="btn btn-gold btn-medium" type="button" ng-click="teacher.clearSearch()">Cancel</button>
	</div>
</div>