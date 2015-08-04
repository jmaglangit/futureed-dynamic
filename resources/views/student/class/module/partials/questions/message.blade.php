<div id="message_modal" ng-show="mod.module_message.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="title-main-content"> {! mod.module_message.name !} </h3>
			</div>
			<div class="modal-body message-container">
				<div class="col-xs-12" >
					<p class="module-message">Let's get started...</p>
				</div>

				<div class="module-icon-holder">
					<img src="/images/avatar/doctor-male/doctor_male-2_main.png" />
				</div>

				<div class="points-badge-holder row">
					<div class="col-xs-12">
						<img ng-src="/images/icons/icon-reward.png"/> Reward points to earn
					</div>

					<div class="col-xs-12">
						<p class="message-point">+{! mod.module_message.points_to_finish !}</p>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<div class="btn-container">
					{!! Form::button('Begin Lesson'
						, array(
							'class' => 'btn btn-maroon btn-medium'
							, 'data-dismiss' => 'modal'
							, 'ng-click' => 'mod.skipModule()'
						)
					) !!}

					{!! Form::button('Later'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'data-dismiss' => 'modal'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>
</div>