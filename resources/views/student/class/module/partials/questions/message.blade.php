<div id="message_modal" ng-show="mod.module_message.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="title-main-content" ng-if="mod.module_message.skip_module"> {! mod.module_message.name !} </h3>
				<h3 class="title-main-content" ng-if="mod.module_message.module_done"> {! mod.module_message.name !} Module Complete </h3>
			</div>
			<div class="modal-body message-container">
				<div ng-if="mod.module_message.skip_module">
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
							<p class="message-point">+{! mod.module_message.points_earned !}</p>
						</div>
					</div>
				</div>

				<div ng-if="mod.module_message.module_done">
					<div class="points-badge-holder row">
						<div class="col-xs-12">
							<p class="message-point">+{! mod.module_message.points_earned !}</p>
						</div>

						<div class="col-xs-12">
							Congratulations! You have earned {! mod.module_message.points_earned !} points.
						</div>
					</div>


					<div class="col-xs-12" >
						<p class="module-message">Congratulations...</p>
					</div>

					<div class="module-icon-holder">
						<img src="/images/avatar/doctor-male/doctor_male-2_main.png" />
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<div class="btn-container">
					<div ng-if="mod.module_message.skip_module">
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
					<div ng-if="mod.module_message.module_done">
						{!! Html::link(route('student.class.index'), 'Class Dashboard'
							, array(
								'class' => 'btn btn-maroon btn-medium'
							)
						) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>