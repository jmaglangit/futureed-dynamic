<div ng-if="class.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>Edit Class</span>
		</div>
	</div>
	
	<div class="module-container">
		<div class="alert alert-error" ng-if="class.errors">
            <p ng-repeat="error in class.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="class.success">
        	<p>{! class.success !}</p>
        </div>

		{!! Form::open(
			[
				'id' => 'edit_class_name_form',
				'class' => 'form-horizontal'
			]
		) !!}
		<div class="form-group">
			<label class="col-xs-2 control-label">Class Name <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::text('class_name', '',['class' => 'form-control', 'ng-model' => 'class.record.name', 'placeholder' => 'Class Name']) !!}
			</div>
		</div>

		<div class="btn-container col-xs-5 col-xs-offset-2">
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
		{!! Form::close() !!}
	</div>
</div>