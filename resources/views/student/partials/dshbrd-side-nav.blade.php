<ul ng-if="!profile.active_play_game" ng-init=" profile.active_games ? futureed.false : profile.setStudentProfileActive()">

	<li class="active">
		<a href="{!! route('student.dashboard.index') !!}">
			<i class="fa fa-arrow-left"></i> {!! trans('messages.back_to_dashboard') !!}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_index || profile.active_edit_email || profile.active_confirm_email}">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive(futureed.INDEX)">{!! trans('messages.my_profile') !!}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_edit }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive(futureed.EDIT)">{!! trans('messages.edit_profile') !!}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_rewards }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive(futureed.REWARDS)">{!! trans('messages.student_rewards') !!}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_avatar_accessory }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive(futureed.AVATAR_ACCESSORY)">{!! trans('messages.avatar_accessories') !!}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_avatar }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive(futureed.AVATAR)">{!! trans('messages.change_avatar') !!}</a>
	</li>

	<li ng-if="!user.media_login" ng-class="{ 'active' : profile.active_password }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive(futureed.PASSWORD)">{!! trans('messages.student_change_picture_password') !!}</a>
	</li>

	<li ng-if="!user.media_login" ng-class="{ 'active' : profile.settings }">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive(futureed.SETTINGS)">{{ trans('messages.change_background') }}</a>
	</li>

	<li ng-class="{ 'active' : profile.active_games}">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive(futureed.GAMES)">{{ trans_choice('messages.game',2) }}</a>
	</li>
</ul>
<ul ng-if="profile.active_play_game">
	<li ng-class="{ 'active' : profile.active_play_game}">
		<a href="javascript:void(0)" ng-click="profile.setStudentProfileActive(futureed.GAMES)">
			<i class="fa fa-arrow-left"></i> {{ trans('messages.back_to_games') }}</a>
	</li>
</ul>