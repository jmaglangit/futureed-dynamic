<div class="login-container form-style enter-pass-con form-select-password" ng-if="login.active_enter_password">
	<div ng-if="!locked">
		<div class="title">{!! trans('messages.student_select_pic_password') !!}</div>

		<div class="alert alert-danger" ng-if="login.errors">
			<p ng-repeat="error in login.errors" > 
				{! error !}
			</p>
		</div>

		<div class="form_content">
			<ul class="form_password list-unstyled list-inline">
				<li class="item col-xs-4" ng-repeat="item in login.image_pass" 
					ng-class="{ 'selected' : login.manual.image_id == item.id }"
					ng-click="login.selectPassword(item.id)">
					<img ng-src="{! item.url !}" class="login-img" alt="{! item.name !}">
				</li>
			</ul>
		</div>

		<div class="btn-container" ng-if="login.image_pass.length">
			{!! Form::button(trans('messages.cancel')
				, array(
					'class' => 'btn btn-gold btn-medium'
					, 'ng-click' => 'login.cancelLogin()'
				)
			) !!}
		</div>
	</div>
</div>
  