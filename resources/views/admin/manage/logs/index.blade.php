@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageLogsController as logs" 
		 ng-init="logs.setActive()" ng-cloak>

		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">

			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>

			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content">
						<span ng-if="logs.active_security_log">Security Logs</span>
						<span ng-if="logs.active_administrator_log">Administrator Logs</span>
						<span ng-if="logs.active_users_log">Users Logs</span>
						<span ng-if="logs.active_system_log">System Logs</span>
						<span ng-if="logs.active_errors_log">Error Logs</span>
					</div>
				</div>

			    <ul class="nav nav-pills nav-admin">
					<li role="presentation" ng-class="{ 'active' : logs.active_security_log }">
						<a href="javascript:void(0)" ng-click="logs.setActive(futureed.SECURITY)">Security</a></li>
					<li role="presentation" ng-class="{ 'active' : logs.active_administrator_log }">
						<a href="javascript:void(0)" ng-click="logs.setActive(futureed.ADMINISTRATOR)">Administrator</a></li>
					<li role="presentation" ng-class="{ 'active' : logs.active_users_log }">
						<a href="javascript:void(0)" ng-click="logs.setActive(futureed.USERS)">Users</a></li>
					<li role="presentation" ng-class="{ 'active' : logs.active_system_log }">
						<a href="javascript:void(0)" ng-click="logs.setActive(futureed.SYSTEM)">System</a></li>
					<li role="presentation" ng-class="{ 'active' : logs.active_errors_log }">
						<a href="javascript:void(0)" ng-click="logs.setActive(futureed.ERRORS)">Errors</a></li>
				</ul>

				<div template-directive template-url="{!! route('admin.manage.logs.partials.security_list_form') !!}"></div>

				<div template-directive template-url="{!! route('admin.manage.logs.partials.admin_list_form') !!}"></div>

				<div template-directive template-url="{!! route('admin.manage.logs.partials.user_list_form') !!}"></div>

				<div template-directive template-url="{!! route('admin.manage.logs.partials.system_list_form') !!}"></div>

				<div template-directive template-url="{!! route('admin.manage.logs.partials.errors_list_form') !!}"></div>
			</div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_logs_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_logs_service.js')!!}
@stop