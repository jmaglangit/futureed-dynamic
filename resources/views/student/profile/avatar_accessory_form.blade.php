<div ng-if="profile.active_avatar_accessory">
	<div class="col-md-12">
		<div class="form-class">
			<div class="clearfix" ng-if="profile.has_accessories">
				<ul class="nav navbar-nav">
					<li class="nav-label">{!! trans('messages.cash_points') !!}</li>
					<li class="nav-points-rewards">
						{!! Html::image('/images/icons/icon-cash-points.png', ''
							, array(
								'class' => 'nav-icon-holder'
							)
						) !!} {! user.cash_points !}
					</li>
				</ul>
			</div>
			<ul class="avatar_list list-unstyled list-inline" ng-init="profile.getAvatarAccessories()">
				<li class="item avtr-accessory"
					ng-repeat="accessory in profile.avatar_accessories"
					ng-class="{ 'accessory-bought' : accessory.is_bought }"
				>
					<a 	 href="{! accessory.url !}"
						 alt="{! accessory.name !}"
						 class="accessory-img"
					>
						<img ng-src="{! accessory.url !}"
						   ng-class="!accessory.is_bought ? 'greyscale' : ''"
						   alt="{! accessory.name !}">
					</a>
					<p class="text-gold text-center">{! accessory.points_to_unlock !} points</p>
					<p class="text-gold text-center">{! accessory.name !}</p>
					{!! Form::button(trans('messages.buy')
						, array(
							'class' => 'btn btn-maroon btn-medium center-block'
							, 'ng-click' => 'profile.confrimBuyAvatarAccessory(accessory.id, accessory.points_to_unlock)'
							, 'ng-if' => '!accessory.is_bought'
						)
					) !!}
				</li>
			</ul>
		</div>
	</div>
</div>

<div id="buy_avatar_accessory_modal" ng-show="profile.buy_avatar_accessory_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				{!! trans('messages.buy_accessory') !!}
			</div>
			<div class="modal-body center-date">
				<div class="alert alert-error" ng-if="profile.errors">
					<p>
						{! error !}
					</p>
				</div>
				<div ng-if="!profile.errors">
					<p>{!! trans('messages.are_you_sure_you_want_to_buy_accessory') !!}</p>
				</div>
			</div>
			<div class="modal-footer">
				<div class="btncon col-md-8 col-md-offset-4 pull-left">
					{!! Form::button(trans('messages.buy')
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => 'profile.buyAvatarAccessory(profile.accessory_id, profile.points_to_unlock)'
						)
					) !!}

					{!! Form::button(trans('messages.cancel_caps')
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