<div ng-if="teacher.email">
	<div class="content-title">
		<div class="title-main-content">
			<span>Change Email</span>
		</div>
	</div>
	<div class="container">
		{!! Form::open(['class' => 'form-horizontal', 'id' => 'change_email']) !!}
		<div class="col-xs-8 col-xs-offset-2 margin-60-top">
			<div class="form-group">
				<label class="control-label col-xs-3">Current Email <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! 
						Form::text('current_email', '', 
							[
								'class' => 'form-control',
								'ng-model' => 'student.current_email',
								'placeHolder' => 'Current Email'
							])
					!!}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">New Email <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! 
						Form::text('new_email', '', 
							[
								'class' => 'form-control',
								'ng-model' => 'student.new_email',
								'placeHolder' => 'New Email'
							])
					!!}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">Confirm Email <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! 
						Form::text('confirm_email', '', 
							[
								'class' => 'form-control',
								'ng-model' => 'student.current_email',
								'placeHolder' => 'Confirm Email'
							])
					!!}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">Enter your Password <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! 
						Form::password('password', 
							[
								'class' => 'form-control',
								'ng-model' => 'student.password',
								'placeHolder' => 'Password'
							])
					!!}
				</div>
			</div>
			<div class="col-xs-8 col-xs-offset-2">
				<div class="btn-container">
					<button class="btn btn-blue btn-medium">Submit</button>
					<button class="btn btn-gold btn-medium">Back</button>
				</div>
			</div>
		</div>
	</div>
</div>