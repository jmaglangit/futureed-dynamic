<div class="col-xs-12">
	<div class="col-xs-6 col-xs-offset-3">
		{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-horizontal'
					, 'ng-submit' => 'tips.searchFnc($event)'
				)
			)!!}
		<div class="form-group">
			<div class="col-xs-12">
				{!! Form::text('search_module', ''
					,array(
						'placeholder' => 'Search Subject'
						, 'ng-model' => 'tips.search.title'
						, 'class' => 'form-control btn-fit'
					)
				)!!}
			</div>
		</div>
		{{-- Only Sample Datas are shown on the select inputs --}}
		<div class="form-group">
			<div class="col-xs-4">
				{!! Form::select('search_status'
					, array(
						'' => '-- Subject --'
						, 'Pending' => 'Pending'
						, 'Accepted' => 'Accepted'
					)
					, ''
					, array(
						'class' => 'form-control'
						, 'ng-model' => 'tips.search.status'
					)
				) !!}
			</div>
			<div class="col-xs-4">
				{!! Form::select('search_status'
					, array(
						'' => '-- Grade --'
						, 'Pending' => 'Pending'
						, 'Accepted' => 'Accepted'
					)
					, ''
					, array(
						'class' => 'form-control'
						, 'ng-model' => 'tips.search.status'
					)
				) !!}
			</div>
			<div class="col-xs-4">
				{!! Form::select('search_status'
					, array(
						'' => '-- Status All --'
						, 'Pending' => 'Pending'
						, 'Accepted' => 'Accepted'
					)
					, ''
					, array(
						'class' => 'form-control'
						, 'ng-model' => 'tips.search.status'
					)
				) !!}
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	{{-- no Data's yet. --}}
	<div class="container margin-top-30">
		<a href="{!! route('student.class.modulename',['name' => 'sample-page']) !!}"><img class="module-icon" src="/images/class-student/icon-addition.png"></a>
	</div>
</div>