<div ng-if="profile.active_avatar_accessory">
	<div class="col-md-12">
		<div class="form-class">
			<ul class="avatar_list list-unstyled list-inline" ng-init="profile.getAvatarAccessories()">
				<li class="item avtrcon" ng-repeat="accessory in profile.avatar_accessories">
					<img ng-src="{! accessory.url !}" alt="{! accessory.name !}">
					<p class="text-gold text-center">{! accessory.points_to_unlock !} points</p>
					{!! Form::button('BUY'
						, array(
							'class' => 'btn btn-maroon btn-medium center-block'
							, 'ng-click' => ''
						)
					) !!}
				</li>
			</ul>
	</div>
</div>