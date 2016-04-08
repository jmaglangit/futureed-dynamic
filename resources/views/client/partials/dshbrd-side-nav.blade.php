<div ng-cloak>
	<div class="client-prof">
		<div class="client-title" ng-if="user.role == futureed.PRINCIPAL">
			{!! trans('messages.client_principal_dashboard') !!}
		</div>
		<div class="client-title" ng-if="user.role == futureed.TEACHER">
			{!! trans('messages.client_teacher_dashboard') !!}
		</div>
		<div class="client-title" ng-if="user.role == futureed.PARENT">
			{!! trans('messages.client_parent_dashboard') !!}
		</div>
		<div class="client-name">
			{!! trans('messages.welcome') !!}, {! user.first_name !}
		</div>
		<div class="back-link">
			{!! HTML::link(route('client.dashboard.index'),trans('messages.back_to_dashboard')) !!}
		</div>
	</div>

	<div class="title-row" ng-if="profileActive">
		{!! trans('messages.my_account') !!}
	</div>

	<ul ng-init="profile.setClientProfileActive()"  ng-if="profileActive">
		<li ng-class="{ 'active' : profile.active_index || profile.active_edit_email || profile.active_confirm_email }">
			<a href="" ng-click="profile.setClientProfileActive('index')"><span><i class="fa fa-book"></i></span>{!! trans('messages.view_client_account_profile') !!}</a>
		</li>
		<li ng-class="{ 'active' : profile.active_edit }">
			<a href="" ng-click="profile.setClientProfileActive('edit')"><span><i class="fa fa-edit"></i></span>{!! trans('messages.edit_client_account_profile') !!}</a>
		</li>
		<li ng-class="{ 'active' : profile.active_password }">
			<a href="" ng-click="profile.setClientProfileActive('password')"><span><i class="fa fa-lock"></i></span>{!! trans('messages.change_password') !!}</a>
		</li>
	</ul>
	<ul ng-if="!profileActive  && user.role == futureed.PARENT">
		<li class="client-nav" ng-class="{ 'tab-active' : student.active == 'student' }">
			<a href="{{ route('client.parent.student.index') }}"><span><i class="fa fa-user"></i></span>{!! trans('messages.student') !!}</a>
		</li>
		<li class="client-nav" ng-class="{ 'tab-active' : payment.active == 'payment' }">
			<a href="{{ route('client.parent.payment.index') }}"><span><i class="fa fa-edit"></i></span>{!! trans('messages.payment') !!}</a>
		</li>
		<li class="client-nav" ng-class="{ 'tab-active' : module.active == 'module' || content.active == 'module' || question.active == 'module'}">
			<a href="{{ route('client.parent.module.index') }}"><span><i class="fa fa-cubes"></i></span>{!! trans('messages.module') !!}</a>
		</li>
	</ul>
	<ul ng-if="!profileActive  && user.role == futureed.TEACHER">
		<li class="client-nav" ng-class="{ 'tab-active' : teacher.active == 'teacher' }">
			<a href="{{ route('client.teacher.student.index') }}"><span><i class="fa fa-user"></i></span>{!! trans('messages.student') !!}</a>
		</li>
		<li class="client-nav" ng-class="{ 'tab-active' : class.active == 'class' }">
			<a href="{{ route('client.teacher.class.index') }}"><span><i class="fa fa-users"></i></span>{!! trans('messages.class') !!}</a>
		</li>
		<li class="client-nav" ng-class="{ 'tab-active' : module || content || question}">
			<a href="{{ route('client.teacher.module.index') }}"><span><i class="fa fa-cubes"></i></span>{!! trans('messages.module') !!}</a>
		</li>
	</ul>
	<ul ng-if="!profileActive  && user.role == futureed.PRINCIPAL">
		<li class="client-nav" ng-class="{ 'tab-active' : teacher.active == 'teacher' }">
			<a href="{{ route('client.principal.teacher.index') }}"><span><i class="fa fa-users"></i></span>{!! trans('messages.teacher') !!}</a>
		</li>
		<li class="client-nav" ng-class="{ 'tab-active' : payment.active == 'payment' }">
			<a href="{{ route('client.principal.payment.index') }}"><span><i class="fa fa-credit-card"></i></span>{!! trans('messages.payment') !!}</a>
		</li>
	</ul>
</div>