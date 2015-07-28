<div id="message_modal" ng-show="mod.module_message.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			<h3> Basic Addition </h3>
			</div>
			<div class="modal-body message-container">
				<div class="col-xs-12" >
					<p class="module-message">Let's get started...</p>
				</div>

				<div class="module-icon-holder">
					<img src="http://localhost:8000/images/avatar/doctor-male/doctor_male-2_main.png" />
				</div>

				<div class="points-badge-holder row">
					<div class="col-xs-12">
						<div class="col-xs-6">
							<img ng-src="/images/icons/icon-reward.png"/> Reward points to earn
						</div>
						<div class="col-xs-6">
							<img ng-src="/images/icons/icon-badges.png"/> Badge to earn
						</div>
					</div>

					<div class="col-xs-12">
						<div class="col-xs-6">
							<p class="message-point">+12</p>
						</div>
						<div class="col-xs-6">
							<img class="message-badge" src="/images/badges/math/boys/math_badge_boy_grade_1.png" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="btn-container">
					{!! Form::button('Begin Lesson'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'data-dismiss' => 'modal'
							, 'ng-click' => 'mod.skipModule()'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>
</div>