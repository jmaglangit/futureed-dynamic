<div class="col-xs-12 search-container" ng-if="module.active_view">
	<div class="title-mid">
		<span>Module Details</span>		
	</div>
    <div class="module-container">
    	{!! Form::open(
			array(
				'class' => 'form-horizontal'
			)
		) !!}
		<div class="form-group">
			<label class="control-label col-xs-2">Module</label>
			<div class="col-xs-4">
				{!! Form::text('module', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.name'
						, 'placeholder' => 'Module'
					)
				) !!}
			</div>
			<label class="control-label col-xs-2">Subject</label>
			<div class="col-xs-4">
				{!! Form::text('subject', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.subject.name'
						, 'placeholder' => 'Subject'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Area</label>
			<div class="col-xs-4">
				{!! Form::text('area', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.subject_area.name'
						, 'placeholder' => 'Area'
					)
				) !!}
			</div>
			<label class="control-label col-xs-2">Grade</label>
			<div class="col-xs-4">
				{!! Form::text('grade', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.grade.name'
						, 'placeholder' => 'Grade'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Common Core Area</label>
			<div class="col-xs-4">
				{!! Form::text('core_area', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.common_core_area'
						, 'placeholder' => 'Common Core Area'
					)
				) !!}
			</div>
			<label class="control-label col-xs-2">Common Core URL</label>
			<div class="col-xs-4">
				{!! Form::text('core_area', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.common_core_url'
						, 'placeholder' => 'Common Core URL'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">Description</label>
			<div class="col-xs-10">
				{!! Form::textarea('description', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control disabled-textarea'
						, 'ng-model' => 'module.record.description'
						, 'placeholder' => 'Description'
						, 'rows' => '5'
					)
				) !!}
			</div>
		</div>
		<div class="btn-container">
			<div class="col-xs-6 col-xs-offset-3">
				{!! Form::button('Back'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "module.setActive()"
					)
				) !!}
			</div>
		</div>
    </div>
</div>