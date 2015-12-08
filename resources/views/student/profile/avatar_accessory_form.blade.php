<div ng-if="profile.active_avatar_accessory">
	<div class="col-md-12">
		<div class="form-class">
			<div>
				<p>Cash Points: <span class="text-gold"> {! profile.points_used !}</span></p>
			</div>
			<ul class="avatar_list list-unstyled list-inline" ng-init="profile.getAvatarAccessories()">
				<li class="item avtrcon" ng-repeat="accessory in profile.avatar_accessories">
					<img ng-src="{! accessory.url !}" ng-class="!accessory.isBought ? 'greyscale' : ''" alt="{! accessory.name !}">
					<p ng-if="!accessory.isBought" class="text-gold text-center">{! accessory.points_to_unlock !} points</p>
					{!! Form::button('BUY'
						, array(
							'class' => 'btn btn-maroon btn-medium center-block'
							, 'ng-click' => 'profile.buyAvatarAccessory(accessory.id, accessory.points_to_unlock)'
							, 'ng-if' => '!accessory.isBought'
						)
					) !!}
				</li>
			</ul>
	</div>
</div>