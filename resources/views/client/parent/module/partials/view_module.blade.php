<div class="col-xs-12 search-container" ng-if="module.active_view">
	<div class="title-mid">
		<span>{!! trans('messages.admin_module_details') !!}</span>		
	</div>
    <div class="module-container">
    	{!! Form::open(
			array(
				'class' => 'form-horizontal'
			)
		) !!}
		<div class="form-group">
			<label class="control-label col-xs-2">{!! trans_choice('messages.module', 1) !!}</label>
			<div class="col-xs-4">
				{!! Form::text('module', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.name'
						, 'placeholder' => trans('messages.module')
					)
				) !!}
			</div>
			<label class="control-label col-xs-2">{!! trans('messages.subject') !!}</label>
			<div class="col-xs-4">
				{!! Form::text('subject', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.subject.name'
						, 'placeholder' => trans('messages.subject')
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">{!! trans('messages.area') !!}</label>
			<div class="col-xs-4">
				{!! Form::text('area', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.subjectarea.name'
						, 'placeholder' => trans('messages.area')
					)
				) !!}
			</div>
			<label class="control-label col-xs-2">{!! trans_choice('messages.grade', 1) !!}</label>
			<div class="col-xs-4">
				{!! Form::text('grade', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.grade.name'
						, 'placeholder' => trans_choice('messages.grade', 1)
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">{!! trans('messages.admin_common_core_area') !!}</label>
			<div class="col-xs-4">
				{!! Form::text('core_area', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.common_core_area'
						, 'placeholder' => trans('messages.admin_common_core_area')
					)
				) !!}
			</div>
			<label class="control-label col-xs-2">{!! trans('messages.admin_common_core_url') !!}</label>
			<div class="col-xs-4">
				<a class="form-control-link" href="{! module.record.common_core_url !}">{! module.record.common_core_url !}</a>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">{!! trans('messages.description') !!}</label>
			<div class="col-xs-10">
				{!! Form::textarea('description', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control disabled-textarea'
						, 'ng-model' => 'module.record.description'
						, 'placeholder' => trans('messages.description')
						, 'rows' => '5'
					)
				) !!}
			</div>
		</div>
		<div class="btn-container">
			<div class="col-xs-6 col-xs-offset-3">
				{!! Form::button(trans('messages.back')
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "module.setActive()"
					)
				) !!}
			</div>
		</div>
    </div>
</div>