@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="AdminDashboardController as admincon" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')				
			</div>
			<div class="announce-content">
				<div class="content-title">
					<div class="title-main-content">
						<span><i class="fa fa-gear"></i> System Settings</span>
					</div>
				</div>
				<div class="form-content col-xs-12" ng-controller="AnnouncementController as announce">
					<div class="alert alert-danger" ng-if="announce.errors">
						<p ng-repeat="error in announce.errors">
							{! error !}
						</p>
					</div>
					<div class="alert alert-info" ng-if="announce.is_success">
						<p>
							{! announce.is_success !}
						</p>
					</div>
					<div class="subtitle-content">
						<span><i class="fa fa-plus-square"></i> Create Client Announcement</span>
					</div>
					{!! Form::open([
						'id' => 'announcement_form'
						, 'class' => 'form-horizontal'
						]) !!}
						<fieldset>
							<legend class="legend-name-mid legend-announce"></legend>
								<div class="col-xs-10">
									<div class="row">
									 	<div class="form-group">
									 		<div class="col-xs-6">
									 			<label class="content-label announce-label">Date Start</label>
									            <div class="dropdown">
			                              <a class="dropdown-toggle" id="dropdown1" role="button" data-toggle="dropdown" data-target="#" href="#">
			                                <div class="input-group">
			                                    <input readonly="readonly" type="text" name="date_start" placeholder="DD/MM/YY" class="form-control" value="{! announce.date_start | date:'dd/MM/yy' !}">
			                                    <input type="hidden" name="hidden_start" ng-model="announce.date_start" value="{! announce.date_start | date:'yyyyMMdd' !}">
			                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                                </div>
			                              </a>
			                              <ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel">
			                                <datetimepicker data-ng-model="announce.date_start" data-before-render="announce.beforeDate($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown1', startView:'day', minView:'day' }"/>
			                              </ul>
			                            </div>
								            </div>
								            <div class="col-xs-6">
								            <label class="content-label announce-label">Date End</label>
									            <div class="dropdown">
			                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
			                                <div class="input-group">
			                                    <input readonly="readonly" type="text" name="date_end" placeholder="DD/MM/YY" class="form-control" value="{! announce.date_end | date:'dd/MM/yy' !}">
			                                    <input type="hidden" name="hidden_end" ng-model="announce.date_end" value="{! announce.date_end | date:'yyyyMMdd' !}">
			                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                                </div>
			                              </a>
			                              <ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel">
			                                <datetimepicker data-ng-if="announce.date_start" data-ng-model="announce.date_end" data-before-render="announce.afterDateStart($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
			                              </ul>
			                            </div>
								            </div>

								    </div>
								   </div>
								   <div class="row">
								   		<label class="announce-label">Your Message</label>	
								   		{!! Form::textarea('announce_message',''
								   			,[
								   				'class' => 'form-control'
								   				,'rows' => '10'
								   				, 'style' => 'resize:vertical;'
								   				, 'ng-model' => 'announce.announce_message'
								   			]) !!}
								   </div>
								   <div class="btn-container">
								   		<button class="btn btn-blue btn-medium" ng-click="announce.saveAnnounce()" type="button">Save</button>
								   		<button class="btn btn-gold btn-medium" type="button">Clear</button>
								   </div>					
								</div>				
						</fieldset>	
				</div>
			</div>
		</div>		
	</div>
	
@stop

@section('footer')

@overwrite
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/datatables_controller.js')!!}
	{!! Html::script('/js/admin/controllers/dashboard_controller.js')!!}
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js')!!}
	{!! Html::script('/js/admin/controllers/announcement_controller.js')!!}
	{!! Html::script('/js/admin/services/announcement_service.js')!!}

@stop