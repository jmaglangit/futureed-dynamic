<div ng-if="profile.active_rewards">
	<div class="alert alert-info">
		No Rewards yet.
	</div>

	<div class="btn-container">
		{!! Html::link(route('student.profile.index'), 'View Profile'
			, array(
				'class' => 'btn btn-gold btn-medium'
			)	
		) !!}
	</div>
</div>