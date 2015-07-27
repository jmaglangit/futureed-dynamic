<div class="container search-container" ng-if="module.active_view">
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
			<label class="control-label col-xs-3">Module</label>
			<div class="col-xs-5">
				{!! Form::text('module', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.name'
						, 'placeholder' => 'Module'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-3">Subject</label>
			<div class="col-xs-5">
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
			<label class="control-label col-xs-3">Area</label>
			<div class="col-xs-5">
				{!! Form::text('area', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.subject_area.name'
						, 'placeholder' => 'Area'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-3">Grade</label>
			<div class="col-xs-5">
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
			<label class="control-label col-xs-3">Common Core Area</label>
			<div class="col-xs-5">
				{!! Form::text('core_area', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.common_core_area'
						, 'placeholder' => 'Common Core Area'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-3">Common Core URL</label>
			<div class="col-xs-5">
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
			<label class="control-label col-xs-3">Description</label>
			<div class="col-xs-5">
				{!! Form::textarea('description', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control disabled-textarea'
						, 'ng-model' => 'module.record.description'
						, 'placeholder' => 'Description'
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