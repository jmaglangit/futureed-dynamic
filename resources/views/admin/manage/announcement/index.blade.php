@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="AnnouncementController as announce" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')				
			</div>
			<div class="announce-content">
				<div class="content-title">
					<div class="title-main-content">
						<span><i class="fa fa-bullhorn"></i> {!! trans('messages.admin_announce_client') !!}</span>
					</div>
				</div>
				<div class="form-content col-xs-12">
					<div class="alert alert-danger" ng-if="announce.errors">
						<p ng-repeat="error in announce.errors">
							{! error !}
						</p>
					</div>

					 <div class="alert alert-success" ng-if="announce.data.success">
			        	<p>{!! trans('messages.admin_announce_success_created') !!}</p>
			        </div>
					{!! Form::open([
						'id' => 'announcement_form'
						, 'class' => 'form-horizontal'
						, 'ng-init' => 'announce.getAnnouncement()'
						]) !!}
						<fieldset>
								<div class="col-xs-10">
									<div class="row">
									 	<div class="form-group">
									 		<div class="col-xs-6">
									 			<label class="content-label announce-label">{!! trans('messages.date_start') !!}</label>
									            <div class="dropdown">
			                              <a class="dropdown-toggle" id="dropdown1" role="button" data-toggle="dropdown" data-target="#" href="#">
			                                <div class="input-group">
			                                    <input readonly="readonly" type="text" name="date_start" placeholder="DD/MM/YY" class="form-control" value="{! announce.data.date_start | date:'dd/MM/yy' !}">
			                                    <input type="hidden" name="hidden_start" value="{! announce.data.date_start | date:'y-MM-d' !}">
			                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                                </div>
			                              </a>
			                              <ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel">
			                                <datetimepicker data-ng-model="announce.data.date_start" data-before-render="announce.beforeDate($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown1', startView:'day', minView:'day' }"/>
			                              </ul>
			                            </div>
								            </div>
								            <div class="col-xs-6">
								            <label class="content-label announce-label">{!! trans('messages.date_end') !!}</label>
									            <div class="dropdown">
			                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
			                                <div class="input-group">
			                                    <input readonly="readonly" type="text" name="date_end" placeholder="DD/MM/YY" class="form-control" value="{! announce.data.date_end | date:'dd/MM/yy' !}">
			                                    <input type="hidden" name="hidden_end" value="{! announce.data.date_end | date:'y-MM-d' !}">
			                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                                </div>
			                              </a>
			                              <ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel" ng-if="announce.data.date_start">
			                                <datetimepicker data-ng-if="announce.data.date_start" data-ng-model="announce.data.date_end" data-before-render="announce.beforeDate($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
			                              </ul>
			                            </div>
								            </div>

								    </div>
								   </div>
								   <div class="row">
								   		<label class="announce-label">{!! trans('messages.admin_announce_your_message') !!}</label>	
								   		{!! Form::textarea('announce_message',''
								   			,[
								   				'class' => 'form-control'
								   				,'rows' => '10'
								   				, 'style' => 'resize:vertical;'
								   				, 'ng-model' => 'announce.data.announcement'
								   			]) !!}
								   </div>
								   <div class="btn-container">
								   		<button class="btn btn-blue btn-medium" ng-click="announce.saveAnnounce()" type="button">{!! trans('messages.save') !!}</button>
								   		<button class="btn btn-gold btn-medium" ng-click="announce.clearAnnouncementForm()" type="button">{!! trans('messages.clear') !!}</button>
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
	{!! Html::script('/js/admin/controllers/dashboard_controller.js'. '?size=' . File::size(public_path('/js/admin/controllers/dashboard_controller.js')))!!}
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js')!!}
	{!! Html::script('/js/admin/controllers/announcement_controller.js'. '?size=' . File::size(public_path('/js/admin/controllers/announcement_controller.js')))!!}
	{!! Html::script('/js/admin/services/announcement_service.js'. '?size=' . File::size(public_path('/js/admin/services/announcement_service.js')))!!}

@stop