<div ng-if="student.active_invite">
	<div class="content-title">
		<div class="title-main-content">
			<span>Invitation Code</span>
		</div>
	</div>
	<div class="container form-content">
		<div class="alert alert-error" ng-if="student.errors">
            <p ng-repeat="error in student.errors track by $index" > 
                {! error !}
            </p>
        </div>
        {!! Form::open(['class' => 'form-horizontal', 'id' => '']) !!}
        <div class="col-xs-10 col-xs-offset-1 margin-top-60">
        	<div class="form-group">
        		<label class="control-label col-xs-2">Invitation Code <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('code', '',
						[
							'class' => 'form-control',
							'ng-model' => 'student.reg.invitation_code',
							'placeHolder' => 'Invitation Code'
						]
					) !!}
        		</div>
        		<div class="col-xs-3">
        			{!! Form::button('Proceed'
						, array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'student.submitCode()'
						)
					) !!}
        		</div>
        	</div>
        </div>
	</div>
</div>