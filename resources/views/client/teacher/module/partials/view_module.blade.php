<div class="container search-container" ng-if="module.active_view">
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
			<label class="control-label col-xs-2">{!! trans('messages.module') !!}</label>
			<div class="col-xs-4">
				{!! Form::text('module', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.name'
						, 'placeholder' => 'trans('messages.module')'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">{!! trans('messages.subject') !!}</label>
			<div class="col-xs-4">
				{!! Form::text('subject', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.subject.name'
						, 'placeholder' => 'trans('messages.subject')'
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
						, 'placeholder' => 'trans('messages.area')'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">{!! trans('messages.grade') !!}</label>
			<div class="col-xs-4">
				{!! Form::text('grade', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control'
						, 'ng-model' => 'module.record.grade.name'
						, 'placeholder' => 'trans('messages.grade')'
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
						, 'placeholder' => 'trans('messages.admin_common_core_area')'
					)
				) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">{!! trans('messages.admin_common_core_url') !!}</label>
			<div class="col-xs-4" ng-cloak>
				<a href="{! module.record.common_core_url !}" ng-if="module.record.common_core_url" class="btn btn-blue btn-medium">{!! trans('messages.go_to_link') !!}</a>
				<span ng-if="!module.record.common_core_url" class="upload-label label label-info">{!! trans('messages.no_available_link') !!}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-2">{!! trans('messages.description') !!}</label>
			<div class="col-xs-4">
				{!! Form::textarea('description', ''
					, array(
						'ng-disabled'=>'true'
						, 'class' => 'form-control disabled-textarea'
						, 'ng-model' => 'module.record.description'
						, 'placeholder' => 'trans('messages.description')'
						, 'rows' => '5'
					)
				) !!}
			</div>
		</div>
		<div class="col-xs-9 col-xs-offset-2">
			{!! Form::button('trans('messages.back')'
				, array(
					'class' => 'btn btn-gold btn-medium'
					, 'ng-click' => "module.setActive()"
				)
			) !!}
		</div>
    </div>
</div>