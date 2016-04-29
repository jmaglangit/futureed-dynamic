<div ng-if="profile.active_avatar">
	<div class="alert alert-success" ng-if="profile.success">
		{!! trans('messages.successful_change_avatar') !!}
	</div>

	<div ng-if="!profile.success">
		<div class="col-md-offset-1 col-md-11">
			{!! Form::open(array('id' => 'change_avatar_form')) !!}
			    <div class="form-select-password">
			      <div class="form_content">
			        <ul class="avatar_list list-unstyled list-inline" ng-init="profile.getAvatarImages()">
			          <li class="item avtrcon" ng-class="{selected : avatar.id == profile.prof.avatar_id }" 
			          	ng-repeat="avatar in profile.avatars" ng-click="profile.highlightAvatar($event)">
						  <img ng-src="{! avatar.url !}" alt="{! avatar.name !}">
						  <input type="hidden" id="avatar_id" name="avatar_id" value="{! avatar.id !}">
						  <h5>{! avatar.name !}</h5>
			          </li>
			        </ul>
				  </div>
			    </div>
			{!! Form::close() !!}
		</div>

		<div class="btn-container" ng-if="!profile.success">
			{!! Form::button(trans('messages.client_proceed')
				, array(
					'class' => 'btn btn-maroon btn-medium'
					, 'ng-if' => 'profile.enable'
					, 'ng-click' => 'profile.selectAvatar()'
				)
			) !!}

			{!! Html::link(route('student.profile.index'), trans('messages.cancel')
				, array(
					'class' => 'btn btn-gold btn-medium'
				)	
			) !!}
		</div>
	</div>

	<br />
	
	<div class="btn-container" ng-if="profile.success">
		{!! Html::link(route('student.profile.index'), trans('messages.view_profile')
			, array(
				'class' => 'btn btn-gold btn-medium'
			)	
		) !!}
	</div>
</div>